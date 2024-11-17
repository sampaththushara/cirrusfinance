<?php

namespace app\controllers;

use Yii;
use app\models\CaGroup;
use app\models\CaGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\Html; 
use mpdf\mpdf;

/**
 * CagroupController implements the CRUD actions for CaGroup model.
 */
class CagroupController extends Controller
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
     * Lists all CaGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CaGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CaGroup model.
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
     * Creates a new CaGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
        $model = new CaGroup();

        $type = Yii::$app->request->get('type');
        $parent = Yii::$app->request->get('parent');
        $level = Yii::$app->request->get('level');

        if ($model->load(Yii::$app->request->post())){
            $model->parent_name= $this->get_parents($parent,$level);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        return $this->render('create', [
            'model' => $model, 'type' =>$type, 'parent' => $parent
        ]);       

    }

    /**
     * Updates an existing CaGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CaGroup model.
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
     * Finds the CaGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CaGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CaGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDashboard()
    {
        $query1 =  (new \yii\db\Query());
        $query1 ->select(['id','item_name','code','ca_level'])  
            ->from('ca_group')
            ->where(['statement_type_id' => 1])            
            ->andwhere(['IS', 'parent_id', null])
            ->orderBy(['id' => SORT_ASC]);
        $command1 = $query1->createCommand();
        $data_main = $command1->queryAll();

        $html_bal_sheet = '<div class="col-md-6">
              <div class="panel">
                <div class="panel-heading"> <span class="panel-title">Balance Sheet Items</span>
                </div>
                <div class="panel-body pn">
                  <table class="table table-responsive ">                   
                    <tbody>';

            for ($i=0; $i < count($data_main) ; $i++) {
                $main_item_id   = $data_main[$i]['id'];
                $main_item_name = $data_main[$i]['item_name'];
                $main_code      = $data_main[$i]['code'];
                $ca_level       = $data_main[$i]['ca_level']+1;

                $html_bal_sheet = $html_bal_sheet. '<tr class="primary"><td>
                      <span class="mr5 va-b"></span><b>'.$main_item_name.'</b>&nbsp;</td>
                      <td><b>'.$main_code.'</b></td>
                    <td ><a href="index.php?r=cagroup/create&type=1&parent='.$main_item_id.'&level='.$ca_level.'"><button type="button" class="btn btn-xs btn-success btn-block">New Sub Group</button></a>
                    </td></tr>';

                //--SECOND LEVEL--
                $query2 =  (new \yii\db\Query());
                $query2 ->select(['id','item_name','code','ca_level'])  
                    ->from('ca_group')
                    ->where(['statement_type_id' => 1])            
                    ->andwhere(['parent_id' => $main_item_id])  
                    ->orderBy(['id' => SORT_ASC]);
                $command2 = $query2->createCommand();
                $data_second = $command2->queryAll();
                for ($a=0; $a < count($data_second) ; $a++) {
                    $second_item_id   = $data_second[$a]['id'];
                    $second_item_name = $data_second[$a]['item_name'];
                    $second_code      = $data_second[$a]['code'];
                    $ca_level         = $data_second[$a]['ca_level']+1;

                    $html_bal_sheet = $html_bal_sheet. '<tr><td>
                      <span class="mr5 va-b"></span>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;<b>'.$second_item_name.'</b></td>
                    <td><b>'.$second_code.'</b></td>
                    <td><a href="index.php?r=cagroup/create&type=1&parent='.$second_item_id.'&level='.$ca_level.'"><button type="button" class="btn btn-xs btn-alert btn-block">New</button></a>
                    </td></tr>';

                    //--THIRD LEVEL--
                    $query3 =  (new \yii\db\Query());
                    $query3 ->select(['id','item_name','code','ca_level'])  
                        ->from('ca_group')
                        ->where(['statement_type_id' => 1])            
                        ->andwhere(['parent_id' => $second_item_id])  
                        ->orderBy(['id' => SORT_ASC]);
                    $command3 = $query3->createCommand();
                    $data_third = $command3->queryAll();
                    for ($b=0; $b < count($data_third) ; $b++) {
                        $third_item_id   = $data_third[$b]['id'];
                        $third_item_name = $data_third[$b]['item_name'];
                        $third_code      = $data_third[$b]['code'];
                        $ca_level        = $data_third[$b]['ca_level']+1;

                        $html_bal_sheet = $html_bal_sheet. '<tr><td>
                          <span class="mr5 va-b"></span>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp'.$third_item_name.'</td>
                        <td>'.$third_code.'</td><td></td></tr>';
                    }

                }

            }

        $html_bal_sheet = $html_bal_sheet. '</tbody>
                  </table>
                </div>
              </div>
        </div>';


        //---P&L items--
        $query1 =  (new \yii\db\Query());
        $query1 ->select(['id','item_name','code','ca_level'])  
            ->from('ca_group')
            ->where(['statement_type_id' => 2])            
            ->andwhere(['IS', 'parent_id', null])
            ->orderBy(['id' => SORT_ASC]);
        $command1 = $query1->createCommand();
        $data_main = $command1->queryAll();
        
        $html_profit_loss = '<div class="col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-title">Profit & Loss Items</span>                 
                </div>
                <div class="panel-body pn">
                  <table class="table table-responsive ">                   
                    <tbody>';

            for ($i=0; $i < count($data_main) ; $i++) {
                $main_item_id   = $data_main[$i]['id'];
                $main_item_name = $data_main[$i]['item_name'];
                $main_code      = $data_main[$i]['code'];
                $ca_level       = $data_main[$i]['ca_level']+1;

                $html_profit_loss = $html_profit_loss. '<tr class="primary"><td>
                      <span class="mr5 va-b"></span><b>'.$main_item_name.'</b></td>
                      <td><b>'.$main_code.'</b></td>
                    <td><a href="index.php?r=cagroup/create&type=2&parent='.$main_item_id.'&level='.$ca_level.'"><button type="button" class="btn btn-xs btn-success btn-block">New Sub Group</button></a>
                    </td></tr>';

                //--SECOND LEVEL--
                $query2 =  (new \yii\db\Query());
                $query2 ->select(['id','item_name','code','ca_level'])  
                    ->from('ca_group')
                    ->where(['statement_type_id' => 2])            
                    ->andwhere(['parent_id' => $main_item_id])  
                    ->orderBy(['id' => SORT_ASC]);
                $command2 = $query2->createCommand();
                $data_second = $command2->queryAll();
                for ($a=0; $a < count($data_second) ; $a++) {
                    $second_item_id   = $data_second[$a]['id'];
                    $second_item_name = $data_second[$a]['item_name'];
                    $second_code      = $data_second[$a]['code'];
                    $ca_level         = $data_second[$a]['ca_level']+1;

                    $html_profit_loss = $html_profit_loss. '<tr><td>
                      <span class="mr5 va-b"></span>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp;<b>'.$second_item_name.'</b></td>
                    <td><b>'.$second_code.'</b></td><td><a href="index.php?r=cagroup/create&type=2&parent='.$second_item_id.'&level='.$ca_level.'"><button type="button" class="btn btn-xs btn-alert btn-block">New</button></a>
                    </td></tr>';

                    //--THIRD LEVEL--
                    $query3 =  (new \yii\db\Query());
                    $query3 ->select(['id','item_name','code','ca_level'])  
                        ->from('ca_group')
                        ->where(['statement_type_id' => 2])            
                        ->andwhere(['parent_id' => $second_item_id])  
                        ->orderBy(['id' => SORT_ASC]);
                    $command3 = $query3->createCommand();
                    $data_third = $command3->queryAll();
                    for ($b=0; $b < count($data_third) ; $b++) {
                        $third_item_id   = $data_third[$b]['id'];
                        $third_item_name = $data_third[$b]['item_name'];
                        $third_code      = $data_third[$b]['code'];
                        $ca_level        = $data_third[$b]['ca_level']+1;

                        $html_profit_loss = $html_profit_loss. '<tr><td>
                          <span class="mr5 va-b"></span>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp'.$third_item_name.'</b></td>
                        <td>'.$third_code.'</td><td></td></tr>';
                    }

                }

            }

        $html_profit_loss = $html_profit_loss. '</tbody>
                  </table>
                </div>
              </div>
        </div>';


        return $this->render('dashboard', [
            'html_bal_sheet' => $html_bal_sheet, 'html_profit_loss' => $html_profit_loss
        ]);
    }


    public function actionResponse()
    {
         return $this->render('response');
    }

    public function get_itemlist($statement_type)
    {
        $disp_array=array();
        $x =0 ;
        $query1 =  (new \yii\db\Query());
        $query1 ->select(['id','item_name','code'])  
            ->from('ca_group')
            ->where(['statement_type_id' => $statement_type])            
            ->andwhere(['IS', 'parent_id', null])
            ->orderBy(['id' => SORT_ASC]);
        $command1 = $query1->createCommand();
        $data_main = $command1->queryAll();

        
            for ($i=0; $i < count($data_main) ; $i++) {
                $main_item_id   = $data_main[$i]['id'];
                $main_item_name = $data_main[$i]['item_name'];
                $main_code      = $data_main[$i]['code'];

                /*$disp_array[$x]['id']   = $main_item_id;
                $disp_array[$x]['name'] = $main_item_name;
                $x++;*/

                array_push($disp_array, $main_item_name);
                
                //--SECOND LEVEL--
                $query2 =  (new \yii\db\Query());
                $query2 ->select(['id','item_name','code'])  
                    ->from('ca_group')
                    ->where(['statement_type_id' => 1])            
                    ->andwhere(['parent_id' => $main_item_id])  
                    ->orderBy(['id' => SORT_ASC]);
                $command2 = $query2->createCommand();
                $data_second = $command2->queryAll();
                for ($a=0; $a < count($data_second) ; $a++) {
                    $second_item_id   = $data_second[$a]['id'];
                    $second_item_name = $data_second[$a]['item_name'];
                    $second_code      = $data_second[$a]['code'];
                    
                    /*$disp_array[$x]['id']   = $second_item_id;
                    $disp_array[$x]['name'] = $second_item_name;
                    $x++;*/

                    array_push($disp_array,$second_item_name);

                    //--THIRD LEVEL--
                    $query3 =  (new \yii\db\Query());
                    $query3 ->select(['id','item_name','code'])  
                        ->from('ca_group')
                        ->where(['statement_type_id' => 1])            
                        ->andwhere(['parent_id' => $second_item_id])  
                        ->orderBy(['id' => SORT_ASC]);
                    $command3 = $query3->createCommand();
                    $data_third = $command3->queryAll();
                    for ($b=0; $b < count($data_third) ; $b++) {
                        $third_item_id   = $data_third[$b]['id'];
                        $third_item_name = $data_third[$b]['item_name'];
                        $third_code      = $data_third[$b]['code'];
                        
                        /*$disp_array[$x]['id']   = $third_item_id;
                        $disp_array[$x]['name'] = $third_item_name;
                        $x++;*/

                        array_push($disp_array, $third_item_name);

                    }

                }

            }

        return $disp_array;
        
    }


    //  Create a General Ledger

    public function actionGeneralLedger(){

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

            if(!empty(Yii::$app->request->post('code'))){
                $codes = Yii::$app->request->post('code');
            }
            else{
                $codes = array(); 
            }
            
            return $this->render('general_ledger',[
                'date_from' => $date_from,
                'date_to' => $date_to,
                'codes' => $codes
            ]);
        }

        return $this->render('general_ledger');

    }


    //  Create a General Ledger Pdf

    public function actionGeneralLedgerPdf($arry_data)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_generalLedgerPdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('General Ledger');
        //$mpdf->SetHeader('General Ledger');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("general_ledger.pdf", "I");
    }


    public function actionCoaList(){

        return $this->render('coa_list');

    }


    public function actionCoaListPdf(){
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('_coaListPdf');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Chart of Account List');
        //$mpdf->SetHeader('Chart of Account List');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("chart_of_account_list.pdf", "I");

    }

    public function get_parents($parent,$level)
    {
        $disp_array=array();
        $x =0 ;
        if($level==2){
            $query1 =  (new \yii\db\Query());
            $query1 ->select(['id','item_name','code'])  
                ->from('ca_group')
                ->where(['id' => $parent]);
            $command1 = $query1->createCommand();
            $data_main = $command1->queryAll();        
            for ($i=0; $i < count($data_main) ; $i++) {
                $main_item_name   = $data_main[$i]['item_name'];
                $main_item_id = $data_main[$i]['id'];
            }        
            $parent_path = $main_item_name;
            return $parent_path;
        }
        else{

            $query1 =  (new \yii\db\Query());
            $query1 ->select(['parent_id','item_name','code'])  
                ->from('ca_group')
                ->where(['id' => $parent]);
            $command1 = $query1->createCommand();
            $data_main = $command1->queryAll();        
            for ($i=0; $i < count($data_main) ; $i++) {
                $main_item_name   = $data_main[$i]['item_name'];
                $main_item_id = $data_main[$i]['parent_id'];
            }        

            $query2 =  (new \yii\db\Query());
            $query2 ->select(['id','item_name','code'])  
                ->from('ca_group')
                ->where(['id' => $main_item_id]);
            $command2 = $query2->createCommand();
            $data_main2 = $command2->queryAll(); 

            for ($i=0; $i < count($data_main2) ; $i++) {
                $main_item_top   = $data_main2[$i]['item_name'];
                $main_top_id = $data_main2[$i]['id'];
            }

            $parent_path = $main_item_top.'>>'.$main_item_name;
            return $parent_path;

        }
    }



}
