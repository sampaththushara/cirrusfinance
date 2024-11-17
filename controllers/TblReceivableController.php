<?php

namespace app\controllers;

use Yii;
use app\models\TblReceivable;
use app\models\TblReceivableSearch;
use app\models\PayerMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TblReceivableController implements the CRUD actions for TblReceivable model.
 */
class TblReceivableController extends Controller
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
     * Lists all TblReceivable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblReceivableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblReceivable model.
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
     * Creates a new TblReceivable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TblReceivable();

        if ($model->load(Yii::$app->request->post())) {
            $payer_name = $_POST['payer_name'];
            $payer = PayerMaster::find()->where(['payer_name' => $payer_name])->one();
            if(isset($payer)){
                $payer_id = $payer->payer_id;
                $model->payer_id = $payer_id;
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->receivable_id]);
                }
            }
            else{
                $payer_model = new PayerMaster();
                $payer_model->payer_name = $payer_name;
                $payer_model->payer_status = "active";
                if($payer_model->save(false)){
                    $payer_id = $payer_model->payer_id;
                    $model->payer_id = $payer_id;
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->receivable_id]);
                    }
                }
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblReceivable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->receivable_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblReceivable model.
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

    // Outstanding Receivables
    public function actionOutstandingReceivables()
    {
        return $this->render('outstanding_receivables');
    }

    // Outstanding Receivables
    public function actionOutstandingReceivablesPdf()
    {
        
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('outstanding_receivables_pdf');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Outstanding Receivables');
        //$mpdf->SetHeader('utstanding Receivables');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("outstanding_receivables_pdf.pdf", "I");
    }

    /**
     * Finds the TblReceivable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblReceivable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblReceivable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
