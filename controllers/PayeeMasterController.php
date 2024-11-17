<?php

namespace app\controllers;

use Yii;
use app\models\PayeeMaster;
use app\models\PayeeMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayeeMasterController implements the CRUD actions for PayeeMaster model.
 */
class PayeeMasterController extends Controller
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
     * Lists all PayeeMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayeeMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayeeMaster model.
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
     * Creates a new PayeeMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayeeMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payee_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PayeeMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payee_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PayeeMaster model.
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


    // Add payer / payee in admin panel
    public function actionAdminPanel()
    {
        return $this->render('admin_panel');
    }


    public function actionGetPayeeId()
    {
        if(isset($_POST['payeeName']) && $_POST['payeeName'] != "")
        {
            $payeeName = $_POST['payeeName'];

            $payee = PayeeMaster::find()->where(['payee_name' => $payeeName])->one();

            if(empty($payee)){
                $model = new PayeeMaster();
                $model->payee_name = $payeeName;
                $model->payee_status = 'active';
                if($model->save()){
                    $payeeId = $model->payee_id;
                }
            }
            else{
                $payeeId = $payee->payee_id;
            }
            
            $returnArr = array("payeeId" => $payeeId);

            print_r(json_encode($returnArr));

        }
        exit();

    }


    /**
     * Finds the PayeeMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayeeMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayeeMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
