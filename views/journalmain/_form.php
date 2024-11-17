<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\AccBusiness;
use app\models\AccBankAccount;
use app\models\AccCashAccount;
use app\models\AccSubContractor;
use app\models\journaldetail;
use app\models\CaGroup;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\Typeahead;
use kartik\date\DatePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Journalmain */
/* @var $form yii\widgets\ActiveForm */


use wbraganca\dynamicform\DynamicFormWidget; 

$total_cr = 0;
$total_dr = 0;

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
    .width-10{
        width: 10% !important;
    }
    .width-25{
        width: 25% !important;
    }
    .width-150{
        width: 150px !important;
    }
    .journal-create-category .form-group{
        width: 186px;
        margin-right: 1px;
        display: inline-block;
    }
    .journal-create-category i{
        width: 19px;
        color: #afaeae !important;
        font-size: 20px;
        vertical-align: super;
        cursor: pointer;
    }
    .journal-create-category a:hover i{
        color: #185fb3 !important;
        transition: 0.5s;
    }

</style>

<div class="admin-form theme-primary mw1000 center-block">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
            <span> Journal Entry </span>            
        </div>

        <div class="row" id="spy1">   
        <div class="col-md-3">          
            <?php
            echo $form->field($model, "journal_date")->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Journal Entry date'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
            ])->label(FALSE);
            ?>        
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'reference_no')->textInput(['placeholder'=>'Reference No','maxlength' => true])->label(FALSE) ?>            
        </div>
    </div> 

    <div class="row" id="spy1"> 
        <div class="col-md-6">
       
            <?php
            echo $form->field($model, 'business_id')->widget(DepDrop::classname(), [
                'data'=>ArrayHelper::map(AccBusiness::find()->andWhere(['status'=>1])->all(), 'business_id', 'business_name'),
                'options' => ['placeholder' => 'Select ...'],
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

        </div>
    </div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <br>

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
            <div class="panel-body">
                 <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 30, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsJournalItems[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'chart_of_acc_id',
                        'rpt_detail_desc',
                        //'quantity',
                        //'unit_price',
                        'line_total',
                    ],
                ]); 
                ?>

                <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsJournalItems as $i => $modelsJournalItems): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->                    
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (! $modelsJournalItems->isNewRecord) {
                                    echo Html::activeHiddenInput($modelsJournalItems, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-3 journal-create-category">
                                    <?php

                                    echo $form->field($modelsJournalItems, "[{$i}]coa_category")->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(CaGroup::find()->andWhere(['=','ca_level', 1])->all(), 'id', 'item_name'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Category', 'class' => 'journal-create-category'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])->label(false);

                                    ?>
                                    <a href="index.php?r=cagroup/dashboard" target="_blank" title="Create New Chart of Account Item"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-sm-2 suspense">
                                    <?php
                                    echo $form->field($modelsJournalItems, "[{$i}]chart_of_acc_id")->widget(DepDrop::classname(), [
                                        'language' => 'en',
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'options' => ['placeholder' => 'Suspense'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'depends'=>['journaldetail-'.$i.'-coa_category'],
                                            'url'=>Url::to(['/journalmain/select-coa-list']),
                                            'loadingText' => 'Loading ...',
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>

                                <div class="col-sm-2">
                                    <?= $form->field($modelsJournalItems, "[{$i}]subcontractor")->widget(DepDrop::classname(),
                                        [
                                            'language' => 'en',
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'pluginOptions' => [
                                                'allowClear'=>true,
                                                'depends'=>['journaldetail-'.$i.'-chart_of_acc_id'],
                                                'placeholder'=>'Sub Contractor',
                                                'url'=>Url::to(['/journalmain/select-subcontractor']),
                                                'loadingText' => 'Loading ...',
                                            ],
                                        ])->label(false);
                                    ?>

                                </div>
                                <div class="col-sm-2 width-10">
                                    <?php
                                        // Normal select with ActiveForm & model
                                        echo $form->field($modelsJournalItems, "[{$i}]dr_or_cr")->widget(Select2::classname(), [
                                            'data' => ['D'=>'Dr', 'C'=>'Cr'],
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Dr/Cr', 'onchange' => 'getCrDr($(this))'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(FALSE);
                                    ?>
                                </div>

                                <div class="col-sm-2">
                                    <?= $form->field($modelsJournalItems, "[{$i}]journal_detail_desc")->textInput(['maxlength' => true,'placeholder'=>'Description'])->label(FALSE) ?>
                                </div>
                                <!--div class="col-sm-2">
                                    <?= $form->field($modelsJournalItems, "[{$i}]quantity")->textInput(['maxlength' => true,'placeholder'=>'Quantity'])->label(FALSE) ?>
                                    </div-->
                                <!--div class="col-sm-2">
                                    <?= $form->field($modelsJournalItems, "[{$i}]unit_price")->textInput(['maxlength' => true,'placeholder'=>'Unit Price'])->label(FALSE) ?>
                                </div-->

                                <div class="col-sm-2 width-150">
                                    <?= $form->field($modelsJournalItems, "[{$i}]line_total")->textInput(['maxlength' => true, 'placeholder'=>'Amount', 'class' => 'form-control text-right number', 'onkeyup' => 'addCommas()', 'onchange' => 'getTotAmount($(this))'])->label(FALSE) ?>
                                </div>
                                
                                <div class="pull-right">
                                    <!-- <button type="button" onclick="$('.item').load(document.URL +  ' .item');">ref</button> -->
                                    <!-- <?= $form->field($modelsJournalItems, "[{$i}]refresh",['template'=>'<button type="button" class="btn btn-primary"><i class="fa fa-refresh">{input}</i></button>'])->textInput(['onclick' => "alert($(this).attr('id'));"])->label(FALSE) ?> -->
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                            </div><!-- .row -->
                        <!--/div-->
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php DynamicFormWidget::end(); ?>

            </div>
        </div>

        <table class="table">
            <tr>
                <th>Total Debit: </th>
                <td id="total_dr"></td>
                <th>Total Credit: </th>
                <td id="total_cr"></td>
                <th>Balance: </th>
                <td id="total_balance"></td>
                <th id="dr_or_cr"></th>
            </tr>
        </table>

        <script type="text/javascript">
            var arr_cr_amount = [];
            var arr_dr_amount = [];

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }   

            // function refreshDiv(){
            //     var input = $(".refresh-button .form-group").find(':input');
            //     var refreshID = input.attr("id");
            //     var attId = refreshID.replace("journaldetail-", "");
            //     var attId = attId.replace("-refresh", "");
            //     alert(refreshID);
            // }

            function getTotAmount(amount){
                var total_cr = 0;
                var total_dr = 0;
                var lineTotalID = amount.attr("id");
                var attId = lineTotalID.replace("journaldetail-", "");
                var attId = attId.replace("-line_total", "");
                var lineTotal = document.getElementById(lineTotalID).value;
                lineTotal = lineTotal.replace(/,/g, "");
                lineTotal = Number(lineTotal);
                var dr_or_cr = document.getElementById("journaldetail-" + attId + "-dr_or_cr").value;

                if(dr_or_cr == "D"){
                    arr_dr_amount[attId] = lineTotal;
                    arr_cr_amount[attId] = 0;
                }
                else if(dr_or_cr == "C"){
                    arr_cr_amount[attId] = lineTotal;
                    arr_dr_amount[attId] = 0;
                }

                for (var i = arr_dr_amount.length - 1; i >= 0; i--) {
                    total_dr = total_dr + arr_dr_amount[i];
                }
                for (var j = arr_cr_amount.length - 1; j >= 0; j--) {
                    total_cr = total_cr + arr_cr_amount[j];
                }

                if(dr_or_cr == "D"){
                    var balance_dr = total_dr.toFixed(2);
                    document.getElementById("total_dr").innerHTML = numberWithCommas(balance_dr);
                    var balance_cr = total_cr.toFixed(2);
                    document.getElementById("total_cr").innerHTML = numberWithCommas(balance_cr);
                }
                else if(dr_or_cr == "C"){
                    var balance_dr = total_dr.toFixed(2);
                    document.getElementById("total_dr").innerHTML = numberWithCommas(balance_dr);
                    var balance_cr = total_cr.toFixed(2);
                    document.getElementById("total_cr").innerHTML = numberWithCommas(balance_cr);
                }
     
                if(total_cr > total_dr){
                    var balance = (total_cr - total_dr).toFixed(2);
                    document.getElementById("total_balance").innerHTML = numberWithCommas(balance);
                    document.getElementById("dr_or_cr").innerHTML = "Cr";
                }
                else if(total_cr < total_dr){
                    var balance = (total_dr - total_cr).toFixed(2);
                    document.getElementById("total_balance").innerHTML = numberWithCommas(balance);
                    document.getElementById("dr_or_cr").innerHTML = "Dr";
                }
                else if(total_cr == total_dr){
                    document.getElementById("total_balance").innerHTML = 0.00;
                    document.getElementById("dr_or_cr").innerHTML = "";
                }
                
            }

            function getCrDr(cr_dr){
                var total_cr = 0;
                var total_dr = 0;
                var crDrID = cr_dr.attr("id");
                var attId = crDrID.replace("journaldetail-", "");
                var attId = attId.replace("-dr_or_cr", "");
                var dr_or_cr = document.getElementById(crDrID).value;
                var line_total = document.getElementById("journaldetail-" + attId + "-line_total").value;
                line_total = line_total.replace(/,/g, "");
                line_total = Number(line_total);

                if(line_total != null || line_total.length > 0){
                    if(dr_or_cr == "D"){
                        arr_dr_amount[attId] = line_total;
                        arr_cr_amount[attId] = 0;
                    }
                    else if(dr_or_cr == "C"){
                        arr_cr_amount[attId] = line_total;
                        arr_dr_amount[attId] = 0;
                    }

                    for (var i = arr_dr_amount.length - 1; i >= 0; i--) {
                        total_dr = total_dr + arr_dr_amount[i];
                    }
                    for (var j = arr_cr_amount.length - 1; j >= 0; j--) {
                        total_cr = total_cr + arr_cr_amount[j];
                    }

                    if(dr_or_cr == "D"){
                        var balance_dr = total_dr.toFixed(2);
                        document.getElementById("total_dr").innerHTML = numberWithCommas(balance_dr);
                        var balance_cr = total_cr.toFixed(2);
                        document.getElementById("total_cr").innerHTML = numberWithCommas(balance_cr);
                    }
                    else if(dr_or_cr == "C"){
                        var balance_dr = total_dr.toFixed(2);
                        document.getElementById("total_dr").innerHTML = numberWithCommas(balance_dr);
                        var balance_cr = total_cr.toFixed(2);
                        document.getElementById("total_cr").innerHTML = numberWithCommas(balance_cr);
                    }
         
                    if(total_cr > total_dr){
                        var balance = (total_cr - total_dr).toFixed(2);
                        document.getElementById("total_balance").innerHTML = numberWithCommas(balance);
                        document.getElementById("dr_or_cr").innerHTML = "Cr";
                    }
                    else if(total_cr < total_dr){
                        var balance = (total_dr - total_cr).toFixed(2);
                        document.getElementById("total_balance").innerHTML = numberWithCommas(balance);
                        document.getElementById("dr_or_cr").innerHTML = "Dr";
                    }
                    else if(total_cr == total_dr){
                        document.getElementById("total_balance").innerHTML = 0.00;
                        document.getElementById("dr_or_cr").innerHTML = "";
                    }
                }
                
            }

        </script>
            
        </div>

    </div>
     

    <!--?= $form->field($model, 'tot_journal_amount')->textInput() ?-->

    <!--?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?-->

    <!--?= $form->field($model, 'business_duration_id')->textInput() ?-->

    
    <hr class="short alt">

    <div class="form-group">
        <?php print_r($error_msg);?>
    </div>

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
