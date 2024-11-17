<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\PaymentApplication;
use app\models\Tax;
use app\models\CompanyMaster;
use app\models\MaClient;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'VAT Invoice';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "invoice";

$oldid = Invoice::find()->orderBy(['invoice_id'=> SORT_DESC])->one();
if(!empty($oldid)){
    $invoice = $oldid->invoice_id;
    $str = (string)$invoice;
    $inv_id = substr($str, 4);
    $inv_id = (int)$inv_id;
    $new_invoice_id = $inv_id +1;

    $invoice_number = str_pad( $new_invoice_id, 4, 0, STR_PAD_LEFT );
    $year = date('Y');
    $invoice = $year.$invoice_number;
    
}
else{
    $new_invoice_id = 1;
    $invoice_number = str_pad( $new_invoice_id, 4, 0, STR_PAD_LEFT );
    $year = date('Y');
    $invoice = $year.$invoice_number;
}



if(isset($_POST['client_name'])){
    $client_name = $_POST['client_name'];
}
else{
    $client_name = "";
}

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

?>

<style type="text/css">
    .vat-invoice h1{
        margin-bottom: 25px;
        font-size: 23px;
        text-align: center;
        text-transform: uppercase;
    }
    .text-align-right{
        text-align: right;
    }
    .vat-invoice table{
        margin: 50px 0;
    }
</style>

<div class="vat-invoice">

    <div class="admin-form theme-primary mw1000 center-block">

        

        <div class="panel-body bg-light">

            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>

            <img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

            <h1><?= $company_name; ?></h1>
            <br><br>

            <div class="invoice-form">              

                <?php $form = ActiveForm::begin(['id'=>'select-client']); ?>

                <?php 
                $ary = array();
                $clients = PaymentApplication::find()->all();
                foreach ($clients as $client) {
                    $Client_Code = $client->Client_Code;
                    $ma_client_name = MaClient::find()->where(['Client_Code' => $Client_Code])->one()->Client_Name;
                    $ary[$ma_client_name] = $ma_client_name;
                }
                //ar_dump($ary);die();
                ?>
                

                <div class="form-group row">
                    <?php

                        echo '<div class="col-sm-2"><label class="control-label">Payer (Client) :</label></div>';
                        echo '<div class="col-sm-4">';
                        echo Select2::widget([
                            'value' => $client_name,
                            'name' => 'client_name',
                            'data' => $ary,
                            'options' => [
                                'id' => 'client-name',
                                'placeholder' => 'Select Client ...',
                                'selected' => true,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);
                        echo '</div>';
                    ?>  

                    <div class="col-sm-2">
                        <?= Html::submitButton('Process', ['class' => 'btn btn-rounded btn-primary']) ?>
                    </div>  
                </div>

                <?php ActiveForm::end(); ?>

                <!-- Section for after select client -->

                <?php if(!empty($client_name)){ 

                    $Client_Code = MaClient::find()->where(['Client_Name' => $client_name])->one()->Client_Code;

                    $payments = PaymentApplication::find()->where(['Client_Code' => $Client_Code])->all();

                    $form = ActiveForm::begin(['id'=>'my-form']); 

                    $clientAddress = MaClient::find()->where(['Client_Name' => $client_name])->one()->Client_Address;
                    $net_total = 0;
                    ?>

                    <div class="form-group row">
                        
                        <div class="col-sm-2">
                            <label class="control-label">Address :</label>
                        </div>
                        <div class="col-sm-4">
                            <?= $clientAddress; ?>
                        </div>

                    </div>

                    <p class="text-align-right"><strong>Invoice: <?= $invoice; ?></strong></p>

                    <div class="form-group row">
                        <div class="col-sm-8"></div>
                        <label class="control-label col-sm-1" for="invoice_date">Date:</label>
                        <div class="col-sm-3">
                            <?= DatePicker::widget([
                                'name' => 'invoice_date', 
                                'value' => date('Y-m-d'),
                                'options' => ['placeholder' => 'Enter invoice date ...', 'id' => 'invoice_date'],
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    'autoclose' => true
                                ]
                            ]); ?>
                        </div>
                    </div>


                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Invoice</th>
                                <th>Particular</th>
                                <th>Amount</th>
                                <th>VAT</th>
                                <th>NBT</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($payments as $payment) {

                                $payment_id = $payment->id;
                                $invoice_status = $payment->invoice_status;
                                $particular = $payment->particulars;
                                $amount = $payment->amount;
                                $vat = Tax::find()->where(['short_name' => 'VAT'])->one()->tax_ratio;
                                $nbt = Tax::find()->where(['short_name' => 'NBT'])->one()->tax_ratio;
                                $total_tax = $amount + ($amount * $vat / 100);
                                $total = $total_tax + ($total_tax * $nbt / 100);
                                $net_total += $total;

                            ?>

                            <tr>
                                <th><?= $payment_id; ?></th>
                                <th>
                                <?php if($invoice_status == "invoice" && InvoiceDetail::find()->where(['payment_application_id' => $payment_id])->one() !='')
                                { 
                                    $invoice_id = InvoiceDetail::find()->where(['payment_application_id' => $payment_id])->one()->invoice_id;
                                    echo "<a href='index.php?r=invoice/invoice&invoice_id=".$invoice_id."' target='_blank'><i class='fa fa-print' aria-hidden='true'></i> Invoice</a>" ;
                                } 
                                ?>
                                </th>
                                <th><?= $particular; ?></th>
                                <th><?= number_format((float)$amount, 2, '.', ','); ?></th>
                                <th><?= $vat; ?>%</th>
                                <th><?= $nbt; ?>%</th>
                                <th><?= number_format((float)$total, 2, '.', ','); ?></th>
                                <th>
                                    <?php if($invoice_status != "invoice"){ ?>
                                        <input type="checkbox" name="check_payment[]" id="check_payment" value="<?php echo $payment_id; ?>" />
                                    <?php } ?>
                                </th>
                            </tr>

                            <?php } ?>

                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th><?= number_format((float)$net_total, 2, '.', ','); ?></th>
                                <th></th>
                            </tr>
                            
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Retention</th>
                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php 
                            $retention_amount_total = 0;
                            foreach ($payments as $payment) { 
                                $retention_amount = $payment->retention_amount;
                                $retention_amount_total += $retention_amount;
                            ?>
                            <tr>
                                <th></th>
                                <th><?= number_format((float)$retention_amount, 2, '.', ','); ?></th>
                            </tr>
                            <?php } ?>
                            <tr><th>Total</th>
                                <th><?= number_format((float)$retention_amount_total, 2, '.', ','); ?></th>
                            </tr>
                        </tbody>
                    </table>

                    <input type="hidden" name="invoice_id" value="<?= $new_invoice_id; ?>">

                    <!-- <?= $form->field($model, 'invoice_id')->hiddenInput(['value' => $new_invoice_id])->label(false) ?> -->

                    <?= $form->field($model, 'VAT')->hiddenInput(['value' => $vat])->label(false) ?>

                    <?= $form->field($model, 'NBT')->hiddenInput(['value' => $nbt])->label(false) ?>

                    <!-- <?= $form->field($model, 'business_id')->textInput() ?>

                    <?= $form->field($model, 'bill_id')->textInput() ?>

                    <?= $form->field($model, 'invoice_created_by')->textInput(['maxlength' => true]) ?>--> 

                    <?= $form->field($model, 'created_date')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?> 

                    <!-- client name -->
                    <input type="hidden" name="client_name" value="<?= $client_name; ?>" />
                    
                    <hr class="short alt">

                    <div class="form-group">
                        <div class="bs-component">
                            <div class="col-lg-7 col-xs-12">
                                <div class="bs-component">
                                    <div class="col-lg-3 pull-right">   
                                        <?= Html::submitButton('Create Invoice ', ['class' => 'btn btn-primary btn-rounded']) ?>
                                    </div>
                                </div>
                            </div>  

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                    
                <?php } ?>

                

            </div>

        </div>

    </div>

</div>
