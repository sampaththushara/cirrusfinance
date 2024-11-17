<?php

namespace app\controllers;

use Yii;
use app\models\TblPayable;
use app\models\TblPayableSearch;
use app\models\PayeeMaster;
use app\models\ExpenseMaster;
use app\models\Vehicles;
use app\models\VehicleExpenseMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblPayableController implements the CRUD actions for TblPayable model.
 */
class TblPayableController extends Controller
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
     * Lists all TblPayable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblPayableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblPayable model.
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
     * Creates a new TblPayable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblPayable();

        if ($model->load(Yii::$app->request->post())) {
            $payee_name = $_POST['payee_name'];

            // if (!empty($_POST['TblPayable[vehicle_expense_category]'])){
            //     echo "hi";die();
            // }
            // else{
            //     echo "no";
            //     var_dump(Yii::$app->request->post('vehicle_number'));
            //     die();
            // }

            $model->payable_status = "Not Paid";
            $payee = PayeeMaster::find()->where(['payee_name' => $payee_name])->one();
            if(isset($payee)){
                $payee_id = $payee->payee_id;
                $model->payee_id = $payee_id;
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->payable_id]);
                }
            }
            else{
                $payee_model = new PayeeMaster();
                $payee_model->payee_name = $payee_name;
                $payee_model->payee_status = "active";
                if($payee_model->save(false)){
                    $payee_id = $payee_model->payee_id;
                    $model->payee_id = $payee_id;
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->payable_id]);
                    }
                }
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblPayable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payable_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblPayable model.
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

    // Outstanding Payments
    public function actionOutstandingPayments()
    {
        return $this->render('outstanding_payments');
    }

    // Outstanding Payments
    public function actionOutstandingPaymentsPdf()
    {
        
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('outstanding_payments_pdf');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Outstanding Payments');
        //$mpdf->SetHeader('utstanding Payments');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("outstanding_payments_pdf.pdf", "I");
    }

    public function actionGetVehicle(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $expense_category = ExpenseMaster::find()->where(['exp_id' => $parents])->one()->expense_category;
            if (($expense_category == 'Vehicle') || ($expense_category == 'vehicle')) {
                $list = Vehicles::find()->asArray()->all(); 
                $selected  = null;
                if ($parents != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $vehicle) {
                        $out[] = ['id' => $vehicle['vehicle_id'], 'name' => $vehicle['vehicle_number']];
                        if ($i == 0) {
                            $selected = $vehicle['vehicle_id'];
                        }
                    }
                    return ['output' => $out, 'selected'=>''];
                }
            }
            else{
                return ['output'=>'', 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }


    public function actionGetVehicleExpenseCategory(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $expense_category = ExpenseMaster::find()->where(['exp_id' => $parents])->one()->expense_category;
            if (($expense_category == 'Vehicle') || ($expense_category == 'vehicle')) {
                $list = VehicleExpenseMaster::find()->asArray()->all(); 
                $selected  = null;
                if ($parents != null && count($list) > 0) {
                    $selected = '';
                    foreach ($list as $i => $vehicle) {
                        $out[] = ['id' => $vehicle['vehicle_exp_id'], 'name' => $vehicle['vehicle_expense_category']];
                        if ($i == 0) {
                            $selected = $vehicle['vehicle_exp_id'];
                        }
                    }
                    return ['output' => $out, 'selected'=>''];
                }
            }
            else{
                return ['output'=>'', 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }


    public function actionGetPayableIds()
    {
        if(isset($_POST['payableIds']) && $_POST['payableIds'] != "")
        {
            $payableIds = $_POST['payableIds'];
            //$payable_ids_arry = explode(',', $payableIds);
            //$encripted_payable_ids = array();
            // foreach ($payable_ids_arry as $p_id) {
            //     $encrypted_id = base64_encode(gzcompress($p_id, 9));
            //     array_push($encripted_payable_ids, $encrypted_id);
            // }
            
            $returnArr = array("payableIds" => $payableIds);

            print_r(json_encode($returnArr));

        }
        exit();

    }


    /**
     * Finds the TblPayable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblPayable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblPayable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
