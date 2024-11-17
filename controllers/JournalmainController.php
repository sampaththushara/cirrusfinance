<?php

namespace app\controllers;

use Yii;
use app\models\Journalmain;
use app\models\Journaldetail;
use app\models\JournalmainSearch;

use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\AccSubContractor;
use app\models\CaGroup;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 

use app\models\Model;
use yii\web\Response;

/**
 * JournalmainController implements the CRUD actions for Journalmain model.
 */
class JournalmainController extends Controller
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
     * Lists all Journalmain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JournalmainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Journalmain model.
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
     * Creates a new Journalmain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Journalmain();
        $modelsJournalItems = [new Journaldetail];
        $modelentryMain = new AccEntryMain();
        $modelentryDetail = new AccEntryDetail();

        if ($model->load(Yii::$app->request->post()) ) { 

            $modelsJournalItems = Model::createMultiple(Journaldetail::classname());
            Model::loadMultiple($modelsJournalItems, Yii::$app->request->post());

            $dr_tot = 0;
            $cr_tot = 0;
            $tot_journal_amt = 0;
            foreach ($modelsJournalItems as $modelJournalItem) 
            {
                $line_total = $modelJournalItem->line_total;
                $line_total = str_replace(',', '', $line_total);
                $dr_or_cr = $modelJournalItem->dr_or_cr;
                if($dr_or_cr =='D'){
                    $dr_tot += $line_total;
                }
                if($dr_or_cr =='C'){
                    $cr_tot += $line_total;
                }
                $tot_journal_amt +=$line_total;
            }

            // $model->dr_tot = $dr_tot;
            // $model->cr_tot = $cr_tot;
            $model->tot_journal_amount = $tot_journal_amt;
           
            $model->tot_journal_dr = $dr_tot;
            $model->tot_journal_cr = $cr_tot;

            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsJournalItems) && $valid;

            $error_msg = NULL;
            if($dr_tot != $cr_tot){
                $valid = FALSE;
                $error_msg = '<div class="alert alert-sm alert-border-left alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-info pr10"></i>
                <strong>Error!</strong> Debit and Credit Totals are not tally.
                </div>';
            }

            

            
            
            if ($valid) {
                $model->save();
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $tot_journal_amt = 0;
                    $dr_tot = 0;
                    $cr_tot = 0;
                    $i=0;
                    //$arr_item='';
                    if ($flag = $model->save(false)) { 
                        
                        foreach ($modelsJournalItems as $modelJournalItem) {
                            
                            $dr_or_cr = $modelJournalItem->dr_or_cr;

                            $line_total = $modelJournalItem->line_total;
                            $line_total = str_replace(',', '', $line_total);

                            if($dr_or_cr =='D'){
                                $dr_tot += $line_total;
                            }
                            if($dr_or_cr =='C'){
                                $cr_tot += $line_total;
                            }
                            $tot_journal_amt +=$line_total;

                            $modelJournalItem->journal_main_id = $model->journal_id;
                            $modelJournalItem->line_total = $line_total;
                            $modelJournalItem->save();

                            if (! ($flag = $modelJournalItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }                                                 
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        //--update total amount--
                        Journalmain::updateAll(['tot_journal_amount' => $tot_journal_amt], 'journal_id = '.$model->journal_id);

                        //--add chart of acc entries(main)--
                        $modelentryMain->ref_no = $model->reference_no;
                        $modelentryMain->entry_date = $model->journal_date;
                        $modelentryMain->dr_total = $dr_tot;
                        $modelentryMain->cr_total = $cr_tot;
                        $modelentryMain->narration = $model->description;
                        $modelentryMain->business_id = $model->business_id;
                        $modelentryMain->entry_type = 'JE-'.$model->journal_id;
                        $modelentryMain->save(false);

                        foreach ($modelsJournalItems as $modelJournalItem) {
                            //--add chart of acc entries(details)--
                            $modelentryDetail = new AccEntryDetail();
                            $modelentryDetail->char_of_acc_id = $modelJournalItem->chart_of_acc_id;
                            $modelentryDetail->entry_amount = $modelJournalItem->line_total;
                            $modelentryDetail->dr_cr = $modelJournalItem->dr_or_cr;
                            $modelentryDetail->entry_id = $modelentryMain->entry_id;
                            $modelentryDetail->save(false);
                        }                        

                        return $this->redirect(['view', 'id' => $model->journal_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            else{
                $ca_data = $this->get_accounts();
                return $this->render('create', [
                    'model' => $model,
                    'modelsJournalItems'=> (empty($modelsJournalItems)) ? [new AccPaymentDetail] : $modelsJournalItems,
                    'ca_data'=>$ca_data,
                    'error_msg'=>$error_msg
                ]);
            }
        }
        else{
            $error_msg = NULL;
            $ca_data = $this->get_accounts();
            return $this->render('create', [
                'model' => $model,
                'modelsJournalItems'=> (empty($modelsJournalItems)) ? [new AccPaymentDetail] : $modelsJournalItems,
                'ca_data'=>$ca_data,
                'error_msg'=>$error_msg
            ]);
        }

    }

    /**
     * Updates an existing Journalmain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsJournalItems = [new Journaldetail];
        $ca_data = $this->get_accounts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->journal_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelsJournalItems'=> (empty($modelsJournalItems)) ? [new AccPaymentDetail] : $modelsJournalItems,
            'ca_data'=>$ca_data
        ]);
    }

    /**
     * Deletes an existing Journalmain model.
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
     * Finds the Journalmain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Journalmain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Journalmain::findOne($id)) !== null) {
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

     public function actionSelectCoaList(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parent_id = end($_POST['depdrop_parents']);
            $parent_id_second_level = CaGroup::find()->select(['id', 'item_name', 'parent_name'])->where(['parent_id' => $parent_id])->asArray()->all();
            $name = CaGroup::find()->where(['id' => $parent_id])->one()->item_name;

            $selected  = null;
            if ($parent_id != null && count($parent_id_second_level) > 0) {
                $selected = '';
                foreach ($parent_id_second_level as $i => $parent_id_2) {
                    $id = $parent_id_2['id'];
                    $out = [];
                    $item_name = $parent_id_2['item_name'];
                    $parent_id_third_level = CaGroup::find()->where(['parent_id' => $id])->orderBy('parent_name')->all();
                    foreach ($parent_id_third_level as $i => $parent_id_3) {
                        $out[] = ['id' => $parent_id_3['id'], 'name' => $parent_id_3['item_name']];
                        if ($i == 0) {
                            $selected = $parent_id_3['id'];
                        }
                    }
                    $result[$name." >> ".$item_name] = $out;
                }
                //$result = ArrayHelper::map($data, 'id', 'item_name', 'parent_name');
                return ['output' => $result, 'selected'=>''];
                //return $result = ArrayHelper::map($data, 'id', 'item_name', 'parent_name');
            }
            
        }
        return ['output' => '', 'selected'=>''];
    }


    public function actionInvoice($id)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';
        
        $content = $this->renderPartial('_invoice',['id'=>$id]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Journal Entry');
        $mpdf->SetHeader('Journal Entry');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("journal.pdf", "I");
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


    function actionJournal(){

        if(Yii::$app->request->post()){
            if(empty(Yii::$app->request->post('date_from'))){
                $date_from = '01-04-'.date('Y');
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
            
            return $this->render('journal',[
                'date_from' => $date_from,
                'date_to' => $date_to
            ]);
        }

        return $this->render('journal');
    }


    //  Create a Journal Pdf

    public function actionJournalPdf($arry_data)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_journalPdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Journal');
        //$mpdf->SetHeader('Journal');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("journal.pdf", "I");
    }



}
