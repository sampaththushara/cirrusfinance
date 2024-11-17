<?php

namespace app\controllers;

use Yii;
use app\models\AccReceiptMain;
use app\models\AccReceiptMainSearch;
use app\models\AccReceiptDetail;
use app\models\CaGroup;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\AccSubContractor;
use app\models\Invoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\AccBankAccount;
use yii\helpers\Json;
use app\controllers\Query;

use app\models\Model;
use yii\helpers\ArrayHelper; 
use mpdf\mpdf;

/**
 * AccreceiptmainController implements the CRUD actions for AccReceiptMain model.
 */
class AccreceiptmainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'GetAmount' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AccReceiptMain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccReceiptMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccReceiptMain model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AccReceiptMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccReceiptMain();
        $modelsRptItem = [new AccReceiptDetail];
        $modelentryMain = new AccEntryMain();
        $modelentryDetail = new AccEntryDetail();
        if(isset($_REQUEST['type'])){ 
            if($_REQUEST['type'] == 'c'){
                $account_type = 'cash';
                $model->receipt_type = 'cash';
                $debit_chartof_acc_id = 25;
            }
            else {
                $account_type = 'bank';
                $model->receipt_type = 'bank';
                $debit_chartof_acc_id = 26;
            }
        }
        else{
            $account_type = 'bank';
            $model->receipt_type = 'bank';
            $debit_chartof_acc_id = 26;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $invoice_id = $model->invoice_id;

            $modelsRptItem = Model::createMultiple(AccReceiptDetail::classname());
            Model::loadMultiple($modelsRptItem, Yii::$app->request->post());
            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsRptItem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $tot_rpt_amt = 0;
                    $i=0;
                    //$arr_item='';
                    if ($flag = $model->save(false)) { 
                        
                        foreach ($modelsRptItem as $modelRptItem) {                            
                            /*$arr_item[$i]['account']=$modelRptItem->chart_of_acc_id;
                            $arr_item[$i]['desc']=$modelRptItem->rpt_detail_desc;
                            $arr_item[$i]['line_total']=$modelRptItem->line_total;*/
                            $modelRptItem->rpt_main_id = $model->rpt_id;
                            $tot_rpt_amt +=$modelRptItem->line_total;
                            if (! ($flag = $modelRptItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }  
                            //$i++;                                                    
                        }

                        // update receipt balance
                        $invoice_model = Invoice::findOne($invoice_id);
                        if(!empty($invoice_id)){
                            $old_receipt_balance = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->receipt_balance;
                            $new_receipt_balance = $old_receipt_balance - $tot_rpt_amt;
                            $invoice_model->receipt_balance = $new_receipt_balance;
                            $invoice_model->save(false);
                        }
                        
                        
                    }
                    if ($flag) {
                        $transaction->commit();
                        //--update total amount--
                        AccReceiptMain::updateAll(['tot_receipt_amount' => $tot_rpt_amt], 'rpt_id = '.$model->rpt_id);

                        //--add chart of acc entries(main)--
                        $modelentryMain->ref_no = $model->reference_no;
                        $modelentryMain->entry_date = $model->receipt_date;
                        $modelentryMain->dr_total = $tot_rpt_amt;
                        $modelentryMain->cr_total = $tot_rpt_amt;
                        $modelentryMain->narration = $model->description;
                        $modelentryMain->business_id = $model->business_id;
                        $modelentryMain->entry_type = 'RPT-'.$model->rpt_id;
                        $modelentryMain->save(false);

                        //--add chart of acc entries(details) Debit--
                            #--add debit--
                            $modelentryDetail->char_of_acc_id = $debit_chartof_acc_id;
                            $modelentryDetail->entry_amount = $tot_rpt_amt;
                            $modelentryDetail->dr_cr = "D";
                            $modelentryDetail->entry_id = $modelentryMain->entry_id;
                            $modelentryDetail->save(false);
                       
                        foreach ($modelsRptItem as $modelRptItem) { 
                            //--add chart of acc entries(details) Credit--
                            $modelentryDetail = new AccEntryDetail();
                            $modelentryDetail->char_of_acc_id = $modelRptItem->chart_of_acc_id;
                            $modelentryDetail->entry_amount = $modelRptItem->line_total;
                            $modelentryDetail->dr_cr = "C";
                            $modelentryDetail->entry_id = $modelentryMain->entry_id;
                            $modelentryDetail->save();
                        }
                        


                        return $this->redirect(['view', 'id' => $model->rpt_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
            }
            else{
                //echo 'ddd';die;
            }

            //return $this->redirect(['view', 'id' => $model->rpt_id]);
        }
        else{
            $ca_data = $this->get_accounts();

            return $this->render('create', [
                'model' => $model,
                'modelsRptItem'=> (empty($modelsRptItem)) ? [new AccReceiptDetail] : $modelsRptItem,
                'ca_data'=>$ca_data,
                'account_type' => $account_type
            ]);
        }
    }

    /**
     * Updates an existing AccReceiptMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsRptItem = [new AccReceiptDetail];


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rpt_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelsRptItem' => (empty($modelsRptItem)) ? [new AccReceiptDetail] : $modelsRptItem
        ]);
    }

    /**
     * Deletes an existing AccReceiptMain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AccReceiptMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccReceiptMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccReceiptMain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLoad_accounts() {
    $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = AccBankAccount::find()->andWhere(['business_id'=>$id])->asArray()->all();
            //$list = MProvincialList::find()->andWhere(['status'=>1])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['account_id'], 'name' => $account['account_name']];
                    if ($i == 0) {
                        $selected = $account['account_id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function actionBusinessList($q = null) {
        $query = new \yii\db\Query;
        
        $query->select('business_name')
            ->from('acc_business')
            ->where('business_name LIKE "%' . $q .'%"')
            ->orderBy('business_name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['business_name']];
        }
        echo Json::encode($out);
    }


    public function get_accounts(){        
        $query = new \yii\db\Query;
        //--level 0--
        $query->select(['id', 'item_name', 'parent_name'])
             ->from('ca_group')
             ->where(['not like', 'parent_id', 6])
             //->orWhere(['is', 'parent_id',NULL])
             ->andWhere(['=', 'ca_level',3])
             ->orderBy('parent_name')
             ->all();
        $command = $query->createCommand();
        $data1 = $command->queryAll();
        /*$mm=array();
        for ($i=0; $i <count($data1) ; $i++) {              
            $aa = ['id'=>$data1[$i]['id'],'item_name'=>$data1[$i]['item_name']];
            $mm=array_merge($aa);
        }print_r($aa);die;*/

        $result=[];
        foreach($data1 as $array){
            $result = array_merge($result, $array);
        }//print_r($result);die;

        //$array = [$myarray,$aa];
        return $result = ArrayHelper::map($data1, 'id', 'item_name', 'parent_name');
      
    }

    public function actionReceiptPdf($id)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';
        
        $content = $this->renderPartial('_receiptPdf',['id'=>$id]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4','tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Receipt');
        $mpdf->SetHeader('Receipt');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("receipt.pdf", "I");
    }

    /**
     * Displays a Trial Balance form.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTrialBalance()
    {
        if(Yii::$app->request->post()){
            $date = $_POST['trial_balance_date'];

            return $this->render('trial_balance',[
                'entered_date' => $date
            ]);
        }
        return $this->render('trial_balance');
    }

    public function actionTrialBalancePdf($entered_date)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_trialBalancePdf',[
            'entered_date' => $entered_date
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Trial Balance - As at '.$entered_date);
        $date = Date('Y-m-d');
        // $mpdf->SetHeader($date);
        $mpdf->SetFooter($date.' &nbsp; &nbsp;&nbsp;&nbsp; Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("trial_balance.pdf", "I");
    }

    public function actionBalanceSheet()
    {
        if(Yii::$app->request->post()){
            $date = $_POST['balance_sheet_year'];
            $count = $_POST['count'];

            return $this->render('balance_sheet',[
                'entered_date' => $date,
                'count' => $count
            ]);
        }
        return $this->render('balance_sheet');
    }    

    public function actionBalanceSheetPdf($entered_date, $count)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_balanceSheetPdf',[
            'entered_date' => $entered_date,
            'count' => $count
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Balance Sheet - As at '.$entered_date);
        $date = Date('Y-m-d');
        // $mpdf->SetHeader($date);
        $mpdf->SetFooter($date.' &nbsp; &nbsp;&nbsp;&nbsp; Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("balance_sheet.pdf", "I");
    }

    public function actionProfitLoss()
    {
        if(Yii::$app->request->post()){
            $date = $_POST['profit_loss_year'];

            return $this->render('profit_loss',[
                'entered_date' => $date
            ]);
        }
        return $this->render('profit_loss');
    }  

    public function actionProfitLossPdf($entered_date, $count)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_profitLossPdf',[
            'entered_date' => $entered_date,
            'count' => $count
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Profit Loss - As at '.$entered_date);
        $date = Date('Y-m-d');
        // $mpdf->SetHeader($date);
        $mpdf->SetFooter($date.' &nbsp; &nbsp;&nbsp;&nbsp; Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("profit_loss.pdf", "I");
    }

    public function actionReceivableFromDebtors(){

        if(Yii::$app->request->post()){
            if(empty(Yii::$app->request->post('date_from'))){
                $date_from = '01-01-2010';
            }
            else{
                $date_from = Yii::$app->request->post('date_from');
            }

            if(empty(Yii::$app->request->post('date_to'))){
                $date_to = date('d-m-Y');
            }
            else{
                $date_to = Yii::$app->request->post('date_to');
            }

            if(!empty(Yii::$app->request->post('debtors_ref'))){
                $debtors_ref = Yii::$app->request->post('debtors_ref');
            }
            else{
                $debtors_ref = array();
            }
            
            return $this->render('receivable_from_debtors',[
                'date_from' => $date_from,
                'date_to' => $date_to,
                'debtors_ref' => $debtors_ref
            ]);
        }

        return $this->render('receivable_from_debtors');
    }

    public function actionReceivableFromDebtorsPdf($arry_data)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_receivableFromDebtorsPdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Receivable from Debtors');
        //$mpdf->SetHeader('');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("receivable_from_debtors.pdf", "I");
    }

    public function actionInvoice($arry_invoice)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_invoice',[
            'arry_invoice' => $arry_invoice
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Invoice');
        //$mpdf->SetHeader('');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("invoice.pdf", "I");
    }


    public function actionSelectSubcontractor(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $suspense = end($_POST['depdrop_parents']);
            $item_name = CaGroup::find()->where(['id' => $suspense])->one()->item_name;
            //if($item_name == "Subcontractor Payments"){
                if (strpos($item_name, "Sub Contractor") !== false) {
                $list = AccSubContractor::find()->asArray()->all();

                $selected  = null;
                if ($suspense != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $subcontractor) {
                        $out[] = ['id' => $subcontractor['Sub_Contractor_Id'], 'name' => $subcontractor['Sub_Contractor_Name']];
                        if ($i == 0) {
                            $selected = $subcontractor['Sub_Contractor_Id'];
                        }
                    }
                    return ['output' => $out, 'selected'=>''];
                }
            }
            else{
                return ['output' => '', 'selected'=>''];
            }
            
        }
        return ['output' => '', 'selected'=>''];
    }

    public function actionBankReconcilation()
    {
        $model = new AccReceiptMain();
        if(Yii::$app->request->post()){//print_r(Yii::$app->request->post());die;
            $date = $_POST['statement_date'];
            //$statement_amount = $_POST['AccReceiptMain']['statement_amount'];
            $model['statement_date'] = $date;
            //$model['statement_amount'] = $statement_amount;
            return $this->render('bank_reconcil',[
                'statement_date' => $date,
                //'statement_amount' => $statement_amount,
                'model' => $model
            ]);
        }
        return $this->render('bank_reconcil',['model' => $model]);
    }

    public function actionVerify_bankrec_data(){
        if(Yii::$app->request->post()){
            $account_id = $_POST['account_id'];
            $reconcil_amount = $_POST['reconcil_amount'];
            $statement_date = $_POST['statement_date'];
            
            //--receipts--
            $deposits = 0;
            $query_deposits = (new \yii\db\Query())->from('acc_receipt_main')
            ->Where(['reconciled'=> 0])
            ->andWhere(['receipt_type'=> 'bank'])
            ->andwhere(['and', "receipt_date<='$statement_date'"])
            ->andwhere(['and', "account_id='$account_id'"]);
            $deposits = $query_deposits->sum('tot_receipt_amount');

            //--payments--
            $withdrowals=0;
            $query_withdraw = (new \yii\db\Query())->from('acc_payment_main')
            ->Where(['reconciled'=> 0])
            ->andwhere(['and', "payment_date<='$statement_date'"])
            ->andwhere(['and', "account_id='$account_id'"]);
            $withdrowals = $query_withdraw->sum('tot_payment_amount');

            $balance = $deposits - $withdrowals;

            if($reconcil_amount == $balance){
                //--update reconcil status of receipts--               
                Yii::$app->db->createCommand("UPDATE acc_receipt_main SET reconciled=1 WHERE receipt_date<='".$statement_date."' and receipt_type='bank' and account_id='".$account_id."' ")->execute();

                //--update reconcil status of payments--
                Yii::$app->db->createCommand("UPDATE acc_payment_main SET reconciled=1 WHERE payment_date<='".$statement_date."' and account_id='".$account_id."' ")->execute();
                
                Yii::$app->db->createCommand()
                ->update('acc_bank_account', ['last_reconcil' => $statement_date], ['account_id' => $account_id])->execute();
                
                return '<b class="text-success"> Reconciled </b>';
            }
            else{
                /*return '<div class="alert alert-micro alert-danger light alert-dismissable">
                  <i class="fa fa-remove  pr10 hidden"></i>
                  <strong>Not&nbsp;Reconciled</strong>
                </div>';*/
                return '<b class="text-danger"> Not Reconciled! </b>';
            }
            
        }
        else{
            return 'Not Reconciled';
        }
    }




    public function actionSelectAmount(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $invoice_id = end($_POST['depdrop_parents']);

            $amount = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->tot_invoice_amount;

            return $amount;

            
            
        }
        return ['output' => '', 'selected'=>''];
    }


    public function actionGetAmount()
    {

        if(isset($_POST['invoiceId']) && $_POST['invoiceId'] != "")
        {
            $invoiceId = $_POST['invoiceId'];

            $amount = Invoice::find()->where(['invoice_id' => $invoiceId])->one()->tot_invoice_amount;
            $balance = Invoice::find()->where(['invoice_id' => $invoiceId])->one()->receipt_balance;

            $returnArr = array("invoiceId"=>$invoiceId, "amount" => $amount, "balance" => $balance);
            print_r(json_encode($returnArr));

        }
        else
        {
            $returnArr = array("invoiceId"=>0, "amount" => 0, "balance" => 0);
            print_r(json_encode($returnArr));
        }
        exit();

    }




}
