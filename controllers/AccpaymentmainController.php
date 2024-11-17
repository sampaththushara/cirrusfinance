<?php

namespace app\controllers;

use Yii;
use app\models\AccPaymentMain;
use app\models\AccPaymentMainSearch;
use app\models\CaGroup;
use app\models\AccPaymentDetail;
use app\models\AccPaymentProjects;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\AccSubContractor;
use app\models\PostDatedCheque;
use app\models\TblPayable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper; 
use yii\helpers\Json;
use app\controllers\Query;

use app\models\AccBankAccount;

use app\models\Model;

/**
 * AccpaymentmainController implements the CRUD actions for AccPaymentMain model.
 */
class AccpaymentmainController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all AccPaymentMain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccPaymentMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccPaymentMain model.
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
     * Creates a new AccPaymentMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
    public function actionCreate()
    {
        $model = new AccPaymentMain();
        $modelsPmtItems = [new AccPaymentDetail];
        $modelentryMain = new AccEntryMain();
        $modelentryDetail = new AccEntryDetail();
        $modelsPaymentProject = [new AccPaymentProjects];
        $modelOnePaymentProject = new AccPaymentProjects();
        

        if ($model->load(Yii::$app->request->post())) {

            $modelsPmtItems = Model::createMultiple(AccPaymentDetail::classname());
            Model::loadMultiple($modelsPmtItems, Yii::$app->request->post());

            $modelsPaymentProject = Model::createMultiple(AccPaymentProjects::classname());
            Model::loadMultiple($modelsPaymentProject, Yii::$app->request->post());

            $tot_pmt_amt = 0;
            $tot_pmt_cat_amt = 0;

            foreach ($modelsPmtItems as $modelPmtItem) { 
                $tot_pmt_amt += $modelPmtItem->line_total;            
            }
            
            if((!empty($_GET['payable_ids'])) || (!empty($_GET['cheque_ids']))){
                foreach ($modelsPaymentProject as $modelPaymentProject) {
                    $tot_pmt_cat_amt += $modelPaymentProject->paid_amount;
                }

                if($tot_pmt_amt != $tot_pmt_cat_amt){

                    if(!empty($_GET['payable_ids'])){
                        Yii::$app->session->setFlash('check_amount', "<div class='alert alert-danger'>Paid Total Payable Amount and Total Suspense Amount should be equal.</div>");
                    }
                    else if(!empty($_GET['cheque_ids'])){
                        Yii::$app->session->setFlash('check_amount', "<div class='alert alert-danger'>Paid Total Post Dated Cheque Amount and Total Suspense Amount should be equal.</div>");
                    }

                    $ca_data = $this->get_accounts();

                    return $this->render('create', [
                        'model' => $model,
                        'modelsPmtItems'=> (empty($modelsPmtItems)) ? [new AccPaymentDetail] : $modelsPmtItems,
                        'modelsPaymentProject'=> (empty($modelsPaymentProject)) ? [new AccPaymentProjects] : $modelsPaymentProject,
                        'ca_data'=>$ca_data,
                        'modelOnePaymentProject' => $modelOnePaymentProject,
                    ]);
                }
            }

            if((empty($_GET['payable_ids']) && empty($_GET['cheque_ids'])) || (((!empty($_GET['payable_ids'])) || (!empty($_GET['cheque_ids']))) && ($tot_pmt_amt == $tot_pmt_cat_amt))){

                if($model->save()){
                    $pmt_id = $model->pmt_id;

                    if(empty($_GET['payable_ids']) && empty($_GET['cheque_ids'])){
                        if($modelOnePaymentProject->load(Yii::$app->request->post())){
                            $project_id = $modelOnePaymentProject->business_id;
                            $modelOnePaymentProject->pay_main_id = $model->pmt_id;
                            $modelOnePaymentProject->business_id = $project_id;
                            $modelOnePaymentProject->paid_amount = $tot_pmt_amt;
                            $modelOnePaymentProject->save(false);
                        }
                    }
            
                    $modelsPmtItems = Model::createMultiple(AccPaymentDetail::classname());
                    Model::loadMultiple($modelsPmtItems, Yii::$app->request->post());

                    $modelsPaymentProject = Model::createMultiple(AccPaymentProjects::classname());
                    Model::loadMultiple($modelsPaymentProject, Yii::$app->request->post());
                    
                    // validate all models
                    $valid = $model->validate();
                    $valid = Model::validateMultiple($modelsPmtItems) && $valid;
                    //$valid = Model::validateMultiple($modelsPaymentProject) && $valid;

                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            $i=0;
                            //$arr_item='';
                            if ($flag = $model->save(false)) { 
                                
                                foreach ($modelsPmtItems as $modelPmtItem) {                            
                                    /*$arr_item[$i]['account']=$modelPmtItem->chart_of_acc_id;
                                    $arr_item[$i]['desc']=$modelPmtItem->rpt_detail_desc;
                                    $arr_item[$i]['line_total']=$modelPmtItem->line_total;*/
                                    $modelPmtItem->pmt_main_id = $model->pmt_id;
                                    if (! ($flag = $modelPmtItem->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }  
                                    //$i++;                                                    
                                }
                                
                                if((!empty($_GET['payable_ids'])) || (!empty($_GET['cheque_ids']))){

                                    if(!empty($_GET['payable_ids'])){
                                        $get_payable_ids = $_GET['payable_ids'];
                                        $payable_ids_arry = explode(',', $get_payable_ids);
                                    }
                                    else if(!empty($_GET['cheque_ids'])){
                                        $get_cheque_ids = $_GET['cheque_ids'];
                                        $cheque_ids_arry = explode(',', $get_cheque_ids);
                                    }
                                    $index = 0;
                                    foreach ($modelsPaymentProject as $modelPaymentProject) {
                                        $modelPaymentProject->pay_main_id = $model->pmt_id;
                                        if (! ($flag = $modelPaymentProject->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }   
                                        
                                        if($modelPaymentProject->save(false)){

                                            //update payable
                                            if(!empty($_GET['payable_ids'])){
                                                $payable_or_check_id = (int)$payable_ids_arry[$index];
                                                $payable = TblPayable::find()->where(['payable_id' => $payable_or_check_id])->one();
                                                $paid_payable_amount = $payable->paid_payable_amount;
                                                $payable_amount = $payable->payable_amount;
                                                $payable->paid_payable_amount = $paid_payable_amount += $modelPaymentProject->paid_amount;
                                                if($paid_payable_amount >= $payable_amount){
                                                    $payable->payable_status = "Paid";
                                                }
                                                $payable->save(false);
                                            }
                                            // update post dated cheque
                                            else if(!empty($_GET['cheque_ids'])){
                                                $payable_or_check_id = (int)$cheque_ids_arry[$index];
                                                $cheque = PostDatedCheque::find()->where(['id' => $payable_or_check_id])->one();
                                                $paid_chq_amount = $cheque->paid_chq_amount;
                                                $chq_amount = $cheque->chq_amount;
                                                if($paid_chq_amount >= $chq_amount){
                                                    $cheque->chq_status = "Paid";
                                                }
                                                $cheque->paid_chq_amount = $paid_chq_amount += $modelPaymentProject->paid_amount;
                                                $cheque->save(false);
                                            }

                                            // --add chart of acc entries(main)--
                                            $modelentryMain = new AccEntryMain();
                                            $modelentryMain->ref_no = $model->reference_no;
                                            $modelentryMain->entry_date = $model->payment_date;
                                            $modelentryMain->dr_total = $modelPaymentProject->paid_amount;
                                            $modelentryMain->cr_total = $modelPaymentProject->paid_amount;
                                            $modelentryMain->narration = $model->description;
                                            $modelentryMain->business_id = $modelPaymentProject->business_id;
                                            $modelentryMain->entry_type = 'PMT-'.$model->pmt_id;
                                            $modelentryMain->save(false);

                                            //--add chart of acc entries(details)
                                            if($modelentryMain->save(false)){
                                                // add credit
                                                $modelentryDetail = new AccEntryDetail();
                                                $modelentryDetail->char_of_acc_id = 26;
                                                $modelentryDetail->entry_amount = $modelPaymentProject->paid_amount;
                                                $modelentryDetail->dr_cr = "C";
                                                $modelentryDetail->entry_id = $modelentryMain->entry_id;
                                                $modelentryDetail->save(false);

                                                foreach ($modelsPmtItems as $modelRptItem) { 
                                                    // add debit
                                                    $line_total = $modelRptItem->line_total;
                                                    $paid_amount = $modelPaymentProject->paid_amount;
                                                    $paid_amount_percentage = $paid_amount / $tot_pmt_cat_amt;
                                                    $paid_line_total = $line_total * $paid_amount_percentage;

                                                    $modelentryDetail = new AccEntryDetail();
                                                    $modelentryDetail->char_of_acc_id = $modelRptItem->chart_of_acc_id;
                                                    $modelentryDetail->entry_amount = round($paid_line_total);
                                                    $modelentryDetail->dr_cr = "D";
                                                    $modelentryDetail->entry_id = $modelentryMain->entry_id;
                                                    $modelentryDetail->save(false);
                                                }
                                            }
                                        }
                                        $index += 1;
                                    }
                                }   
                            }

                            if ($flag) {
                                $transaction->commit();
                                //--update total amount--
                                AccPaymentMain::updateAll(['tot_payment_amount' => $tot_pmt_amt], 'pmt_id = '.$model->pmt_id);

                                if(empty($_GET['payable_ids']) && empty($_GET['cheque_ids']) && (!empty($modelOnePaymentProject))){

                                    //--add chart of acc entries(main)--
                                    $modelentryMain = new AccEntryMain();
                                    $modelentryMain->ref_no = $model->reference_no;
                                    $modelentryMain->entry_date = $model->payment_date;
                                    $modelentryMain->dr_total = $tot_pmt_amt;
                                    $modelentryMain->cr_total = $tot_pmt_amt;
                                    $modelentryMain->narration = $model->description;
                                    $modelentryMain->business_id = $modelOnePaymentProject->business_id;
                                    $modelentryMain->entry_type = 'PMT-'.$model->pmt_id;
                                    $modelentryMain->save(false);

                                    //--add chart of acc entries(details) Credit--
                                        #--add debit--
                                        $modelentryDetail = new AccEntryDetail();
                                        $modelentryDetail->char_of_acc_id = 26;
                                        $modelentryDetail->entry_amount = $tot_pmt_amt;
                                        $modelentryDetail->dr_cr = "C";
                                        $modelentryDetail->entry_id = $modelentryMain->entry_id;
                                        $modelentryDetail->save(false);

                                        foreach ($modelsPmtItems as $modelRptItem) { 
                                            //--add chart of acc entries(details) Credit--
                                            $modelentryDetail = new AccEntryDetail();
                                            $modelentryDetail->char_of_acc_id = $modelRptItem->chart_of_acc_id;
                                            $modelentryDetail->entry_amount = $modelRptItem->line_total;
                                            $modelentryDetail->dr_cr = "D";
                                            $modelentryDetail->entry_id = $modelentryMain->entry_id;
                                            $modelentryDetail->save(false);
                                        }

                                }

                                
                                //$tot_payment_amount = AccPaymentMain::find()->where(['pmt_id' => $pmt_id])->one()->tot_payment_amount;

                                // if(isset($_GET['cheque_id'])){
                                //     $encoded_cheque_id = $_GET['cheque_id'];
                                //     $cheque_id = gzuncompress(base64_decode($encoded_cheque_id));
                                    
                                //     $PostDatedChequeModel = PostDatedCheque::findOne($cheque_id);
                                //     $checkAmount = $PostDatedChequeModel->chq_amount;

                                //     $paid_chq_amount = $PostDatedChequeModel->paid_chq_amount;
                                //     $tot_paid_chq_amount= $paid_chq_amount + $tot_payment_amount;

                                //     if($checkAmount > $tot_paid_chq_amount){
                                //         $paid_chq_amount = $PostDatedChequeModel->paid_chq_amount;
                                //         $PostDatedChequeModel->paid_chq_amount = $paid_chq_amount + $tot_payment_amount;
                                //         $PostDatedChequeModel->save(false);
                                //     }

                                //     else if($checkAmount <= $tot_paid_chq_amount){
                                //         $PostDatedChequeModel->chq_status = "Paid";
                                //         $PostDatedChequeModel->paid_chq_amount = $tot_paid_chq_amount;
                                //         $PostDatedChequeModel->save(false);
                                //     }
                                // }
                                
                                return $this->redirect(['view', 'id' => $model->pmt_id]);
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
            }
            
        }
        else{
            $ca_data = $this->get_accounts();
            return $this->render('create', [
                'model' => $model,
                'modelsPmtItems'=> (empty($modelsPmtItems)) ? [new AccPaymentDetail] : $modelsPmtItems,
                'modelsPaymentProject'=> (empty($modelsPaymentProject)) ? [new AccPaymentProjects] : $modelsPaymentProject,
                'ca_data'=>$ca_data,
                'modelOnePaymentProject' => $modelOnePaymentProject,

            ]);
        }
    }

    /**
     * Updates an existing AccPaymentMain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPmtItems = [new AccPaymentDetail];
        $modelsPaymentProject = [new AccPaymentProjects];
        $modelOnePaymentProject = new AccPaymentProjects();

        $ca_data = $this->get_accounts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pmt_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelsPmtItems'=> (empty($modelsPmtItems)) ? [new AccPaymentDetail] : $modelsPmtItems,
            'modelsPaymentProject'=> (empty($modelsPaymentProject)) ? [new AccPaymentProjects] : $modelsPaymentProject,
            'ca_data'=>$ca_data,
            'modelOnePaymentProject' => $modelOnePaymentProject,
        ]);
    }

    /**
     * Deletes an existing AccPaymentMain model.
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
     * Finds the AccPaymentMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccPaymentMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccPaymentMain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function get_accounts(){        
        $query = new \yii\db\Query;
        //--level 0--
        $query->select(['id', 'item_name', 'parent_name'])
             ->from('ca_group')
             //->where(['not like', 'parent_id', 6])
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

    public function actionPayslip($id)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';
        
        $content = $this->renderPartial('_payslip',['id'=>$id]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Payment');
        $mpdf->SetHeader('Payment');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("payment.pdf", "I");
    }


    public function actionPayableToCreditors(){

        if(Yii::$app->request->post()){

            if(empty(Yii::$app->request->post('entered_payment_date'))){
                $entered_payment_date = date('d-m-Y');
            }
            else{
                $entered_payment_date = Yii::$app->request->post('entered_payment_date');
            }

            if(!empty(Yii::$app->request->post('creditors_ref'))){
                $creditors_ref = Yii::$app->request->post('creditors_ref');
            }
            else{
                $creditors_ref = array();; 
            }
            

            return $this->render('payable_to_creditors',[
                'entered_payment_date' => $entered_payment_date,
                'creditors_ref' => $creditors_ref
            ]);
        }

        return $this->render('payable_to_creditors');
    }


    public function actionPayableToCreditorsPdf($arry_data){
        
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_payableToCreditorsPdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Payable To Creditors');
        //$mpdf->SetHeader('Trial Balance');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("payable_to_creditors.pdf", "I");
    }



    public function actionSelectSubcontractor(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $suspense = end($_POST['depdrop_parents']);
            $item_name = CaGroup::find()->where(['id' => $suspense])->one()->item_name;
            if(stripos($item_name, 'sub contractor') !== false){
            //if (strpos($item_name, "Sub Contractor") !== false) {
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


    public function actionCreditorDetailsSummary(){

        if(Yii::$app->request->post()){

            if(empty(Yii::$app->request->post('date_to'))){
                $date_to = date('d-m-Y');
            }
            else{
                $date_to = Yii::$app->request->post('date_to');
            }

            if(!empty(Yii::$app->request->post('creditors_ref'))){
                $creditors_ref = Yii::$app->request->post('creditors_ref');
            }
            else{
                $creditors_ref = array();; 
            }
            

            return $this->render('creditor_details_summary',[
                'date_to' => $date_to,
                'creditors_ref' => $creditors_ref
            ]);
        }

        return $this->render('creditor_details_summary');
    }


    public function actionCreditorDetailsSummaryPdf($arry_data){
        
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_creditor_details_summary_pdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Creditor Details Summary');
        //$mpdf->SetHeader('Trial Balance');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("creditor_details_summary.pdf", "I");
    }

    // public function actionSelectPaymentCategory(){
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $out = [];
    //     if (isset($_POST['depdrop_parents'])) {
    //         $category = end($_POST['depdrop_parents']);
    //         if($category == "Pending post dated cheque"){
    //             $list = PostDatedCheque::find()->where(['=','chq_status', 'Not Paid'])->asArray()->all();

    //             $selected  = null;
    //             if ($category != null && count($list) > 0) {
    //                 $selected = '';
    //                 foreach ($list as $i => $cheque) {
    //                     $out[] = ['id' => $cheque['id'], 'name' => $cheque['cheque_no']];
    //                     if ($i == 0) {
    //                         $selected = $cheque['id'];
    //                     }
    //                 }
    //                 return ['output' => $out, 'selected'=>''];
    //             }
    //         }
    //         else if($category == "Pending payable"){
    //             $list = TblPayable::find()->where(['=','payable_status', 'Not Paid'])->asArray()->all();

    //             $selected  = null;
    //             if ($category != null && count($list) > 0) {
    //                 $selected = '';
    //                 foreach ($list as $i => $payable) {
    //                     $out[] = ['id' => $payable['payable_id'], 'name' => $payable['payable_id']];
    //                     if ($i == 0) {
    //                         $selected = $payable['payable_id'];
    //                     }
    //                 }
    //                 return ['output' => $out, 'selected'=>''];
    //             }
    //         }
    //         else{
    //             return ['output' => '', 'selected'=>''];
    //         }
            
    //     }
    //     return ['output' => '', 'selected'=>''];
    // }


    public function actionGetSubCategoryId()
    {
        if(isset($_POST['id']) && $_POST['id'] != "")
        {
            $id = $_POST['id'];
            $paymentCategory = $_POST['paymentCategory'];

            $Arr = array("id" => $id, "paymentCategory" => $paymentCategory);

            $encrypted = base64_encode(gzcompress($id, 9));

            if($paymentCategory == "Pending post dated cheque"){
                $url = "create&cheque_id=".$encrypted;
            }
            else if($paymentCategory == "Pending payable"){
                $url = "create&payable_id=".$encrypted;
            }
            else{
                $url = "create";
            }
            $returnArr = array("url" => $url);

            // return $this->redirect([$decode_url]);
            print_r(json_encode($returnArr));

        }
        exit();

    }


    
}
