<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use app\models\InvoiceDetail;
use app\models\PaymentApplication;
use app\models\Tax;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
                    // 'GetClientDetails' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->invoice_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->invoice_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateInvoice()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) &&  (!empty(Yii::$app->request->post('invoice_date'))) && (!empty($_POST['check_payment']))) {

            $net_total = 0;

            $check_payment = $_POST['check_payment'];
            $date = Yii::$app->request->post('invoice_date');
            $vat = Tax::find()->where(['short_name' => 'VAT'])->one()->tax_ratio;
            $nbt = Tax::find()->where(['short_name' => 'NBT'])->one()->tax_ratio;

            $invoice_id = Yii::$app->request->post("invoice_id");
            $invoice_number = str_pad( $invoice_id, 4, 0, STR_PAD_LEFT );
            $year = date('Y');
            $invoice_number = $year.$invoice_number;

            foreach ($check_payment as $payment_id){ 
                $payment = PaymentApplication::find()->where(['id' => $payment_id])->one();
                $amount = $payment->amount;
                $total_tax = $amount + ($amount * $vat / 100);
                $total = $total_tax + ($total_tax * $nbt / 100);
                $net_total += $total;
            }

            $invoice_date = Yii::$app->request->post('invoice_date');
            $new_date = date("Y-m-d", strtotime($invoice_date));
            $model->invoice_id = $invoice_number;
            $model->invoice_date = $new_date;
            $model->tot_invoice_amount = $net_total;
            $model->receipt_balance = $net_total;
            $model->save();

            foreach ($check_payment as $payment_id){ 

                $modelInvoiceDetail = new InvoiceDetail();
                $modelInvoiceDetail->payment_application_id = $payment_id;
                $modelInvoiceDetail->invoice_id = $model->invoice_id;
                $modelInvoiceDetail->save();

                $modelPaymentApplication = PaymentApplication::findOne($payment_id);
                $modelPaymentApplication->invoice_status = "invoice";
                $modelPaymentApplication->save();
            }
            
            // return $this->redirect(['view', 'id' => $model->invoice_id]);
            return $this->render('_invoiceForm', [
                'model' => $model,
            ]);

        }

        return $this->render('_invoiceForm', [
            'model' => $model,
        ]);
    }

    public function actionInvoice($invoice_id){
        
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('invoice_pdf',[
            'invoice_id' => $invoice_id
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Invoice');
        //$mpdf->SetHeader('Trial Balance');
        $mpdf->WriteHTML($content);
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->Output("invoice.pdf", "I");
    }


    public function actionOverdueInvoiceSummary(){

        if(Yii::$app->request->post()){

            if(empty(Yii::$app->request->post('date_to'))){
                $date_to = date('d-m-Y');
            }
            else{
                $date_to = Yii::$app->request->post('date_to');
            }
            
            return $this->render('overdue_invoice_summary',[
                'date_to' => $date_to
            ]);
        }

        return $this->render('overdue_invoice_summary');
    }


    public function actionOverdueInvoiceSummaryPdf($arry_data)
    {
        require_once Yii::getAlias('@vendor').'/random_compat/lib/random.php';

        $content = $this->renderPartial('overdue_invoice_summary_pdf',[
            'arry_data' => $arry_data
        ]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' => __DIR__ . '/pdf']); //A4-L
        $mpdf->SetTitle('Overdue Invoice Summary');
        //$mpdf->SetHeader('');
        $mpdf->SetFooter('Page {PAGENO} of {nbpg}');
        $mpdf->WriteHTML($content);
        $mpdf->Output("overdue_invoice_summary.pdf", "I");
    }


    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
