<?php

namespace app\controllers;

use Yii;
use app\models\CompanyMaster;
use app\models\CompanyMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanymasterController implements the CRUD actions for CompanyMaster model.
 */
class CompanymasterController extends Controller
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
     * Lists all CompanyMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyMaster model.
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
     * Creates a new CompanyMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyMaster();

        if ($model->load(Yii::$app->request->post())) {

            $path = Yii::getAlias('@web').'/img'; 

            $image = UploadedFile::getInstance($model, 'image');

            if(isset($image)){
                $image = UploadedFile::getInstance($model, 'image');
                $model->image = $image->name;

                $image->saveAs('img/'.$image->name);
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
                $model->image = "";

                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompanyMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $current_image = $model->image;

        if ($model->load(Yii::$app->request->post())) {

            $path = Yii::getAlias('@web').'/img'; 

            $image = UploadedFile::getInstance($model, 'image');

            if(isset($image)){
                $image = UploadedFile::getInstance($model, 'image');
                $model->image = $image->name;

                $image->saveAs('img/'.$image->name);
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
                $model->image = $current_image;

                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompanyMaster model.
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
     * Finds the CompanyMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
