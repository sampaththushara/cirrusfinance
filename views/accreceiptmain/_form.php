<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\AccBusiness;
use app\models\AccBankAccount;
use app\models\AccCashAccount;
use app\models\CaGroup;
use app\models\Invoice;
use app\models\TblReceivable;
use app\models\PayerMaster;
use app\models\ReceivableCategory;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Typeahead;
use kartik\date\DatePicker;
use yii\web\View;

//use dosamigos\datetimepicker\DateTimePicker; 

use wbraganca\dynamicform\DynamicFormWidget;   

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMain */
/* @var $form yii\widgets\ActiveForm */

if(isset($_GET['receivable_id'])){
    $receivable_id = $_GET['receivable_id'];
    $receivable_id = gzuncompress(base64_decode($receivable_id));
    $business_id = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->project_id;
    $business_name = AccBusiness::find()->where(['business_id' => $business_id])->one()->business_name;
    $payer_id = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->payer_id;
    $payer_name = PayerMaster::find()->where(['payer_id' => $payer_id])->one()->payer_name;
    $due_date = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->due_date;
    $amount = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->receivable_amount;
    $description = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->receivable_description;
    $receivable_category_id = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->receivable_category;
    $receivable_category = ReceivableCategory::find()->where(['Receivable_Cat_ID' => $receivable_category_id])->one()->Receivable_Category;
    $period_from = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->period_from;
    $period_to = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->period_to;
    $subcategory_value = $receivable_id;
}
else{
    $business_id = "";
    $payer_name = "";
}

?>

<style>
    .col-sm-3 {
        width: 20%;
        padding-left: 2px;
        padding-right: 2px;
    }
    .col-sm-2 {
        /*width: 20%;*/
        padding-left: 2px;
        padding-right: 2px;
    }
    .form-control {
        height: 33px;
    }
    .receipt-detail{
        background-color: #fff;
        padding: 20px;
        box-shadow: 1px 2px 4px 2px rgba(82, 63, 105, 0.13);
    }
</style>

<div class="admin-form theme-primary mw1000 center-block">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
            <?php 
            if($account_type =='cash'){
                echo '<span> Add New Cash Receipt </span>';
            }
            else{
                echo '<span> Add New Bank Receipt </span>';
            }
            ?>
        </div>

        <div class="row">

            <div class="col-sm-6 col-xs-12">

                <div class="section row" id="spy1">   
                    <div class="col-md-6">          
                        <?php
                        echo $form->field($model, "receipt_date")->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Receipt date'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'todayBtn' => true,
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                        ])->label(FALSE);
                        ?>        
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'reference_no')->textInput(['placeholder'=>'Reference No','maxlength' => true])->label(FALSE) ?>            
                    </div>
                </div>  

                <div class="section row" id="spy1">     
                    <div class="col-md-6">          
                        <?php
                        echo $form->field($model, "invoice_id")->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Invoice::find()->where(['>', 'receipt_balance', 0])->all(), 'invoice_id', 'invoice_id'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Invoice Id', 'onchange' => 'getAmount($(this))'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label("Invoice Id");
                        ?>
                    </div> 

            <script>
                var url="<?php echo  Url::toRoute('accreceiptmain/get-amount'); ?>";
            </script>

<?php 

$script= <<<JS

function getAmount(amount) {
    var invoiceId = document.getElementById("accreceiptmain-invoice_id").value;

    $.ajax(
    {
        type: "post",
        url: url,
        data: {invoiceId:invoiceId},
        dataType: "json",
        cache: false,
        success: function(data)
        {
            document.getElementById("tot_invoice_amount").innerHTML = data.amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById("receipt_balance").innerHTML = data.balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
}

JS;
$this->registerJs($script,View::POS_BEGIN);
?> 
                    
                </div>

                <div class="section row" id="spy1"> 
                    <div class="col-md-12">
               

                    <?php

                    echo $form->field($model, 'business_id')->widget(DepDrop::classname(), [
                        'data'=>ArrayHelper::map(AccBusiness::find()->andWhere(['status'=>1])->all(), 'business_id', 'business_name'),
                        'options' => ['placeholder' => 'Select ...', 'value' => $business_id],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['id'],
                            'url' => Url::to(['']),
                            'loadingText' => 'Loading ...',
                            //'initialize'=> true,
                        ]
                    ]);
                    ?> 

                    <?php
                        if($account_type =='cash'){
                            $data = ArrayHelper::map(AccCashAccount::find()->all(), 'account_id', 'account_name');
                        }
                        else{
                            $data = ArrayHelper::map(AccBankAccount::find()->all(), 'account_id', 'account_name');
                        }
                        echo $form->field($model, 'account_id')->widget(DepDrop::classname(), [
                            'data'=>$data,
                            'options' => ['placeholder' => 'Select ...'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'depends'=>['accreceiptmain-business_id'],
                                'url' => Url::to(['/accreceiptmain/load_accounts']),
                                'loadingText' => 'Loading ...',
                                //'initialize'=> true,
                            ]
                        ]);
                    ?>    


                    <?= $form->field($model, "payer_name")->widget(Typeahead::classname(), [
                          'options' => ['placeholder' => 'Choose from existing or enter new', 'value' => $payer_name],
                          'pluginOptions' => ['highlight' => true, 'minLength' => 3],
                          'scrollable' => true,
                          'dataset' => [
                                [
                                    //'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    //'prefetch' => Url::to(['app/app-codes']),
                                    'remote' => [
                                        'url' => Url::to(['site/business_list']) . '&q=%QUERY', 'wildcard' => '%QUERY'
                                     ],
                                     'limit' => 100,
                                ]
                               ]
                          ]); 
                        ?>


                    </div>
                </div>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            </div>

            <!-- Receipt Details -->
            <div class="col-sm-offset-1 col-sm-5 col-xs-12">

                <div class="receipt-detail">
                    <table class="table striped">

                    <?php if(isset($_GET['receivable_id'])){ 

                        if(isset($business_id)){
                            $business_name = AccBusiness::find()->where(['business_id' => $business_id])->one()->business_name;
                        }
                        else{ $business_name = ""; }

                        ?>
                            <tr>
                                <th class="border-top-none">Receivable No </th>
                                <td><?= $receivable_id; ?></td>
                            </tr>
                            <tr>
                                <th>Due Date </th>
                                <td><?= $due_date; ?></td>
                            </tr>
                            <tr>
                                <th>Project </th>
                                <td><?= $business_name; ?></td>
                            </tr>
                            <tr>
                                <th>Payer Name </th>
                                <td><?= $payer_name; ?></td>
                            </tr>
                            <tr>
                                <th>Receivable Amount </th>
                                <td><?= number_format((float)$amount, 2, '.', ','); ?></td>
                            </tr>
                            <tr>
                                <th>Receivable Category </th>
                                <td><?= $receivable_category; ?></td>
                            </tr>
                            <tr>
                                <th>Description </th>
                                <td><?= $description; ?></td>
                            </tr>
                            <tr>
                                <th>Date From </th>
                                <td><?= $period_from; ?></td>
                            </tr>
                            <tr>
                                <th>Date To </th>
                                <td><?= $period_to; ?></td>
                            </tr>
                            <tr><th></th><td></td></tr>

                        <?php } ?>

                        <tr>
                            <th class="border-top-none">Total Invoice Amount</th>
                            <td id="tot_invoice_amount" class="border-top-none"></td>
                        </tr>

                        <tr>
                            <th>Receipt Balance</th>
                            <td id="receipt_balance"></td>
                        </tr>

                    </table>
                </div>

            </div>

        </div>
                    

    

    <hr>

    <div class="row">
        <div class="panel panel-default">
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsRptItem[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'chart_of_acc_id',
                    'rpt_detail_desc',
                    //'quantity',
                    //'unit_price',
                    'line_total',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsRptItem as $i => $modelsRptItem): ?>
                <div class="item panel panel-default"><!-- widgetBody -->                    
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelsRptItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelsRptItem, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //print_r($ca_data);die;
                                    // Normal select with ActiveForm & model
                                    echo $form->field($modelsRptItem, "[{$i}]chart_of_acc_id")->widget(Select2::classname(), [
                                        'data' => $ca_data,
                                        /*ArrayHelper::map(CaGroup::find()->andWhere(['ca_level'=>3])->all(), 'id', 'item_name'),*/
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Suspense'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(FALSE);
                                ?>

                            </div>

                            <div class="col-sm-3">
                                <?= $form->field($modelsRptItem, "[{$i}]subcontractor")->widget(DepDrop::classname(),
                                    [
                                        'language' => 'en',
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'allowClear'=>true,
                                            'depends'=>['accreceiptdetail-'.$i.'-chart_of_acc_id'],
                                            'placeholder'=>'Sub Contractor',
                                            'url'=>Url::to(['/accreceiptmain/select-subcontractor']),
                                            'loadingText' => 'Loading ...',
                                        ],
                                    ])->label(false);
                                ?>

                            </div>

                            <div class="col-sm-4">
                                <?= $form->field($modelsRptItem, "[{$i}]rpt_detail_desc")->textInput(['maxlength' => true,'placeholder'=>'Description'])->label(FALSE) ?>
                            </div>
                            <!--div class="col-sm-2">
                                <?= $form->field($modelsRptItem, "[{$i}]quantity")->textInput(['maxlength' => true,'placeholder'=>'Quantity'])->label(FALSE) ?>
                                </div-->
                            <!--div class="col-sm-2">
                                <?= $form->field($modelsRptItem, "[{$i}]unit_price")->textInput(['maxlength' => true,'placeholder'=>'Unit Price'])->label(FALSE) ?>
                            </div-->
                            <div class="col-sm-2">
                                <?= $form->field($modelsRptItem, "[{$i}]line_total")->textInput(['maxlength' => true,'placeholder'=>'Amount', 'class' => 'form-control text-right'])->label(FALSE) ?>
                            </div>
                            <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        </div><!-- .row -->
                    <!--/div-->
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
        
    </div>

    <hr class="short alt">

    <div class="form-group">
        <div class="bs-component">
            <div class="col-lg-7 col-xs-12">
                <div class="bs-component">
                    <div class="col-lg-3 pull-right">   
                        <?= Html::submitButton('Save', ['class' => 'btn btn-rounded btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>  

        </div>
    </div>
     


    <?php ActiveForm::end(); ?>
    </div>
</div>
</div>