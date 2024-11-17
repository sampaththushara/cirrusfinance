<?php

namespace app\controllers;

use Yii;
use app\models\PostDatedCheque;
use app\models\PostDatedChequeSearch;
use app\models\PayeeMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostdatedchequeController implements the CRUD actions for PostDatedCheque model.
 */
class PostdatedchequeController extends Controller
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
     * Lists all PostDatedCheque models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostDatedChequeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PostDatedCheque model.
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
     * Creates a new PostDatedCheque model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostDatedCheque();

        if ($model->load(Yii::$app->request->post())) {
            $model->chq_status = 'Not Paid';
            $payee_name = $model->customer_name;
            $payee = PayeeMaster::find()->where(['payee_name' => $payee_name])->one();
            if(isset($payee)){
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
                $payee_model = new PayeeMaster();
                $payee_model->payee_name = $payee_name;
                $payee_model->payee_status = "active";
                if($payee_model->save(false)){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }        
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PostDatedCheque model.
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
     * Deletes an existing PostDatedCheque model.
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

    public function actionGetChequeIds()
    {
        if(isset($_POST['chequeIds']) && $_POST['chequeIds'] != "")
        {
            $chequeIds = $_POST['chequeIds'];
            
            $returnArr = array("chequeIds" => $chequeIds);

            print_r(json_encode($returnArr));

        }
        exit();

    }

    /**
     * Finds the PostDatedCheque model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostDatedCheque the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostDatedCheque::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
