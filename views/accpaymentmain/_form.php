<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\AccBusiness;
use app\models\AccBankAccount;
use app\models\CaGroup;
use app\models\AccSubContractor;
use app\models\TblPayable;
use app\models\PayeeMaster;
use app\models\ExpenseMaster;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Typeahead;
use kartik\date\DatePicker;
use app\models\PostDatedCheque;
use yii\web\View;

//use dosamigos\datetimepicker\DateTimePicker; 

use wbraganca\dynamicform\DynamicFormWidget;   

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMain */
/* @var $form yii\widgets\ActiveForm */


if(isset($_GET['cheque_id'])){
    $cheque_id = $_GET['cheque_id'];
    $cheque_id = gzuncompress(base64_decode($cheque_id));
    $business_id = PostDatedCheque::find()->where(['id' => $cheque_id])->one()->business_id;
    $account_id = PostDatedCheque::find()->where(['id' => $cheque_id])->one()->account_id;
    $business_name = AccBusiness::find()->where(['business_id' => $business_id])->one()->business_name;
    $payment_category = "Pending post dated cheque";
    $payment_subcategory = $cheque_id;
    $payee_name = PostDatedCheque::find()->where(['id' => $cheque_id])->one()->customer_name;;
    $subcategory_value = PostDatedCheque::find()->where(['id' => $cheque_id])->one()->cheque_no;
    $payable_id = "";
}
else if(isset($_GET['payable_id'])){
    $payable_id = $_GET['payable_id'];
    $payable_id = gzuncompress(base64_decode($payable_id));
    $business_id = TblPayable::find()->where(['payable_id' => $payable_id])->one()->project_id;
    $business_name = AccBusiness::find()->where(['business_id' => $business_id])->one()->business_name;
    $account_id = "";
    $cheque_id = "";
    $payment_category = "Pending payable";
    $payment_subcategory = $payable_id;
    $payee_id = TblPayable::find()->where(['payable_id' => $payable_id])->one()->payee_id;
    $payee_name = PayeeMaster::find()->where(['payee_id' => $payee_id])->one()->payee_name;
    $due_date = TblPayable::find()->where(['payable_id' => $payable_id])->one()->due_date;
    $description = TblPayable::find()->where(['payable_id' => $payable_id])->one()->description;
    $payable_amount = TblPayable::find()->where(['payable_id' => $payable_id])->one()->payable_amount;
    $subcategory_value = $payable_id;
    $cheque_id = "";
}
else{
    $business_name = "";
    $business_id = "";
    $account_id = "";
    $cheque_id = "";
    $payment_category = "";
    $payment_subcategory = "";
    $payee_name = "";
    $subcategory_value = "Select...";
    $payable_id = "";
}

if(!empty($_GET['payee_id'])){
    $get_payee_id_encoded = $_GET['payee_id'];
    $decoded = "";
    for( $i = 0; $i < strlen($get_payee_id_encoded); $i++ ) {
        $b = ord($get_payee_id_encoded[$i]);
        $a = $b ^ 123;  // <-- must be same number used to encode the character
        $decoded .= chr($a);
    }
    $payee_id_arry = explode(",",$decoded);
    $get_payee_id = (int)$payee_id_arry[0];
    $payee_name = PayeeMaster::find()->where(['payee_id' => $get_payee_id])->one()->payee_name;
}
else{
    $get_payee_id = "";
    $get_payee_id_encoded = "";
}

if(!empty($_GET['payable_ids'])){
    $get_payable_ids = $_GET['payable_ids'];
    // $get_payable_ids = atob($get_payable_ids);
    // var_dump($get_payable_ids);die();
    $payment_category = "Pending payable";
    $decoded = "";
    for( $i = 0; $i < strlen($get_payable_ids); $i++ ) {
        $b = ord($get_payable_ids[$i]);
        $a = $b ^ 123;  // <-- must be same number used to encode the character
        $decoded .= chr($a);
    }
    $payable_ids_arry = explode(",",$decoded);
    $display_pending_payable = "block";
}
else{
    $get_payable_ids = "";
    $payable_ids_arry = "";
    $display_pending_payable = "none";
}

if(!empty($_GET['cheque_ids'])){
    $get_cheque_ids = $_GET['cheque_ids'];
    $payment_category = "Pending post dated cheque";
    $decoded = "";
    for( $i = 0; $i < strlen($get_cheque_ids); $i++ ) {
        $b = ord($get_cheque_ids[$i]);
        $a = $b ^ 123;  // <-- must be same number used to encode the character
        $decoded .= chr($a);
    }
    $cheque_ids_arry = explode(",",$decoded);
    $display_post_dated_cheque = "block";
}
else{
    $get_cheque_ids = "";
    $cheque_ids_arry = "";
    $display_post_dated_cheque = "none";
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
    .payment-detail{
        background-color: #fff;
        padding: 20px;
        box-shadow: 1px 2px 4px 2px rgba(82, 63, 105, 0.13);
    }
    .acc-payment-main-create{
        width: 1200px;
        margin-left: -83px;
    }
    .width-150 {
        width: 150px !important;
    }
    .payment-create-category i {
        width: 19px;
        color: #afaeae !important;
        font-size: 20px;
        vertical-align: super;
        cursor: pointer;
    }
    .payment-create-category .form-group {
        width: 150px;
        margin-right: 1px;
        display: inline-block;
    }
    .payment-create-category a:hover i{
        color: #185fb3 !important;
        transition: 0.5s;
    }
</style>

<div class="admin-form theme-primary center-block">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <input type="hidden" name="cheque_id" value="<?= $cheque_id; ?>">

        <input type="hidden" name="payable_id" value="<?= $payable_id; ?>">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
              <span> <?= $this->title; ?> </span>
            </div>

            <div class="row">

                <div class="col-sm-5 col-xs-12">

                    <div class="row"> 
                        <div class="col-md-12">
                            <?php 

                            $data = array();
                            $payee_names = PayeeMaster::find()->all();
                            foreach ($payee_names as $payee) {
                                array_push($data, $payee->payee_name);
                            }

                            if(empty($data)){
                                array_push($data, " ");
                            }

                            // Usage with ActiveForm and model (with search term highlighting)
                            echo $form->field($model, 'payee_name')->widget(Typeahead::classname(),[
                                'options' => ['placeholder' => 'Filter as you type ...', 'value' => $payee_name, 'onchange' => 'getPayee($(this))'],
                                'pluginOptions' => ['highlight'=>true],
                                'dataset' => [
                                    [
                                        'local' => $data,
                                        'limit' => 10
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <?php 
                    if(!empty($get_payee_id)){
                        $display_payment_category = "block";
                    }
                    else{
                        $display_payment_category = "none";
                    }
                    ?>

                    <div class="section row">   
                        <div class="col-md-6">
                            <div id="payment_category" style="display: <?= $display_payment_category; ?>;">
                                <label>Payment Category</label>
                                <?php

                                echo Select2::widget([
                                    'name' => 'payment_category',
                                    'value' => $payment_category,
                                    'data' => ["Pending post dated cheque" => "Pending post dated cheque", "Pending payable" => "Pending payable"],
                                    'options' => [
                                        'placeholder' => 'Select Payment Category',
                                        //'id' => 'payment_category',
                                        'onchange' => 'selectPaymentSubCategory($(this))'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);

                                ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?php 
                            
                                // echo "<label>Payment Sub Category</label>";
                                // echo DepDrop::widget([
                                //     'name' => 'payment_subcategory',
                                //     'id' => 'payment_subcategory',
                                //     'type' => DepDrop::TYPE_SELECT2,
                                //     'pluginOptions' => [
                                //        'allowClear'=> true,
                                //        'depends'  => ['payment_category'],
                                //        'placeholder' => $subcategory_value,
                                //        'url' => Url::to(['/accpaymentmain/select-payment-category']),
                                //        'loadingText' => 'Loading ...',
                                        
                                //     ],
                                //     'options' => ['onchange' => 'getSubCategoryID(this)', 'multiple' => true],
                                // ]);  
                            
                            ?>

                            <div id="post-dated-cheque" style="display: <?= $display_post_dated_cheque; ?>;">
                                <?php

                                echo "<label>Check ID</label>";

                                echo Select2::widget([
                                    'name' => 'payment_subcategory',
                                    'value' => $cheque_ids_arry,
                                    'data' => ArrayHelper::map(PostDatedCheque::find()->andWhere(['=','chq_status', 'Not Paid'])->andWhere(['=','customer_name', $payee_name])->all(), 'id', 'cheque_no'),
                                    'options' => [
                                        'placeholder' => 'Select...',
                                        'multiple' => true,
                                        'onchange' => 'getChequeIds($(this))'
                                    ],
                                ]);

                                ?>
                            </div>

                            <div id="pending-payable" style="display: <?= $display_pending_payable; ?>;">
                                <?php

                                echo "<label>Payable ID</label>";

                                echo Select2::widget([
                                    'name' => 'payment_subcategory',
                                    'value' => $payable_ids_arry,
                                    'data' => ArrayHelper::map(TblPayable::find()->andWhere(['=','payable_status', 'Not Paid'])->andWhere(['=','payee_id', $get_payee_id])->all(), 'payable_id', 'payable_id'),
                                    'options' => [
                                        'placeholder' => 'Select...',
                                        'multiple' => true,
                                        'onchange' => 'getPayableIds($(this))'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">

                        var url = '<?php echo  Url::toRoute('accpaymentmain/get-sub-category-id'); ?>';
                        var payable_url = '<?php echo  Url::toRoute('tbl-payable/get-payable-ids'); ?>';
                        var cheque_url = '<?php echo  Url::toRoute('postdatedcheque/get-cheque-ids'); ?>';
                        var payee_url = '<?php echo  Url::toRoute('payee-master/get-payee-id'); ?>';
                        var getPayeeId = "<?php echo $get_payee_id_encoded; ?>";

                        function selectPaymentSubCategory(category){
                            var category = category.val();
                            if(category == "Pending post dated cheque"){
                                document.getElementById("post-dated-cheque").style.display = "block";
                                document.getElementById("pending-payable").style.display = "none";
                            }
                            else if(category == "Pending payable"){
                                document.getElementById("pending-payable").style.display = "block";
                                document.getElementById("post-dated-cheque").style.display = "none";
                            }
                            else{
                                document.getElementById("post-dated-cheque").style.display = "none";
                                document.getElementById("pending-payable").style.display = "none";
                            }
                        }

                    </script>


<?php 

$script= <<<JS

function enc(str) {
    var encoded = "";
    for (i=0; i<str.length;i++) {
        var a = str.charCodeAt(i);
        var b = a ^ 123;    // bitwise XOR with any number, e.g. 123
        encoded = encoded+String.fromCharCode(b);
    }
    return encoded;
}

function getPayableIds(p_ids) {
    var payableIds = p_ids.val();
    
    $.ajax(
    {
        type: "post",
        url: payable_url,
        data: {payableIds:payableIds},
        dataType: "json",
        cache: false,
        success: function(data)
        {
           //var encodedString = btoa(data.payableIds);
            var payableIds = data.payableIds;
            payableIds = payableIds.toString();
            var encodedIds = enc(payableIds);

            window.location = "index.php?r=accpaymentmain/create&payee_id="+getPayeeId+"&payable_ids="+encodedIds;

        }
    });

}

function getChequeIds(c_ids) {
    var chequeIds = c_ids.val();
    
    $.ajax(
    {
        type: "post",
        url: cheque_url,
        data: {chequeIds:chequeIds},
        dataType: "json",
        cache: false,
        success: function(data)
        {
            var chequeIds = data.chequeIds;
            chequeIds = chequeIds.toString();
            var encodedIds = enc(chequeIds);
            window.location = "index.php?r=accpaymentmain/create&payee_id="+getPayeeId+"&cheque_ids="+encodedIds;

        }
    });

}

function getPayee(name){
    var payeeName = name.val();

    $.ajax(
    {
        type: "post",
        url: payee_url,
        data: {payeeName:payeeName},
        dataType: "json",
        cache: false,
        success: function(data)
        {
            var payeeId = data.payeeId;
            payeeId = payeeId.toString();
            var encodedId = enc(payeeId);
            window.location = "index.php?r=accpaymentmain/create&payee_id="+encodedId;
            if(payeeName == ""){
                document.getElementById("payment_category").style.display = "none";
                document.getElementById("post-dated-cheque").style.display = "none";
                document.getElementById("pending-payable").style.display = "none";
            }
            else{
                document.getElementById("payment_category").style.display = "block";
            }

        }
    });  
    
}

// function getSubCategoryID() {
// var id = document.getElementById("payment_subcategory").value;
// var paymentCategory = document.getElementById("payment_category").value;

// $.ajax(
// {
//     type: "post",
//     url: url,
//     data: {id:id, paymentCategory:paymentCategory},
//     dataType: "json",
//     cache: false,
//     success: function(data)
//     {
//         window.location = "index.php?r=accpaymentmain/"+data.url;

//     }
// });

// }

JS;
$this->registerJs($script,View::POS_BEGIN);

?>

                    <div class="row" id="spy1">   
                        <div class="col-md-6">

                            <?php
                            echo $form->field($model, "payment_date")->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Date'], // Payment date
                            //'type' => DatePicker::TYPE_COMPONENT_APPEND,
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

                                            
                    <div class="row"> 

                        <div class="col-md-12">

                            <?php 

                            if((empty($get_payable_ids)) && (empty($get_cheque_ids))){

                                 echo $form->field($modelOnePaymentProject, "business_id")->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AccBusiness::find()->andWhere(['status'=>1])->all(), 'business_id', 'business_name'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Select ...', 'value' => $business_id],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            }
                         
                            ?> 

                        </div>
                    </div>

                    <div class="row"> 
                        <div class="col-md-12">

                            <?php

                            //if((empty($get_payable_ids)) && (empty($get_cheque_ids))){

                                 echo $form->field($model, "account_id")->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AccBankAccount::find()->where(['or', ['account_type_id'=>2], ['account_type_id'=>3]])->all(), 'account_id', 'account_name'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Select ...', 'value' => $account_id],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);

                                // echo $form->field($model, 'account_id')->widget(DepDrop::classname(), [
                                //     //'data'=>ArrayHelper::map(AccBankAccount::find()->all(), 'account_id', 'account_name'),
                                //     'options' => ['placeholder' => 'Select ...', 'value' => $account_id],
                                //     'type' => DepDrop::TYPE_SELECT2,
                                //     'pluginOptions'=>[
                                //         'allowClear'=>true,
                                //         'depends'=>['accpaymentprojects-business_id'],
                                //         'url' => Url::to(['/accreceiptmain/load_accounts']),
                                //         'loadingText' => 'Loading ...',
                                //     ]
                                // ]);
                            //}
                            // else{
                            //     if(!empty($payable_ids_arry)){
                            //         $payment_category_arry = $payable_ids_arry;
                            //     }
                            //     else if(!empty($cheque_ids_arry)){
                            //         $payment_category_arry = $cheque_ids_arry;
                            //     } 
                            //     if(!empty($payment_category_arry)){
                            //         $acc_arry = array();
                            //         foreach ($payment_category_arry as $p_id) {
                            //             $p_id = (int)$p_id;
                            //             if(!empty($payable_ids_arry)){
                            //                 $project_id = TblPayable::find()->where(['payable_id' => $p_id])->one()->project_id;
                            //             }
                            //             else if(!empty($cheque_ids_arry)){
                            //                 $project_id = PostDatedCheque::find()->where(['id' => $p_id])->one()->business_id;
                            //             }
                            //             $acc_ids = AccBankAccount::find()->where(['business_id' => $project_id])->all();
                            //             foreach ($acc_ids as $acc_id) {
                            //                 $account_id = $acc_id->account_id;
                            //                 $account_name = $acc_id->account_name;
                            //                 if(!in_array($account_id, $acc_arry)){
                            //                     $acc_arry[$account_id] = $account_name;
                            //                 }
                            //             }
                            //         }

                            //         echo $form->field($model, "account_id")->widget(Select2::classname(), [
                            //             'data' => $acc_arry,
                            //             'language' => 'en',
                            //             'options' => ['placeholder' => 'Select ...'],
                            //             'pluginOptions' => [
                            //                 'allowClear' => true
                            //             ],
                            //         ]);

                            //     }
                            // }

                            ?>  
                        </div>
                    </div>  

                     <div class="row"> 
                        <div class="col-md-12">

                            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                        </div>
                    </div>


                </div>

                <!-- Payment Details -->
                <div class="col-sm-7 col-xs-12">

                    <?php
                    if(!empty($payable_ids_arry)){
                        $payment_category_arry = $payable_ids_arry;
                    }
                    else if(!empty($cheque_ids_arry)){
                        $payment_category_arry = $cheque_ids_arry;
                    }
                    else{
                        $payment_category_arry = "";
                    }    
                    ?>

                    <?php if(!empty($payment_category_arry)){ ?>

                        <!-- <div class="alert alert-danger" id="display-error" style="display: none;"> -->
                            <?= Yii::$app->session->getFlash('check_amount') ?>
                        <!-- </div> -->

                        <div id="display-payable">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php if($payment_category_arry == $payable_ids_arry){ ?>
                                            <th>Due Date</th>
                                            <th>Project</th>
                                            <th>Payable Amount</th>
                                        <?php } else if($payment_category_arry == $cheque_ids_arry){ ?>
                                            <th>Cheque Date</th>
                                            <th>Project</th>
                                            <th>Post Dated Cheque Amount</th>
                                        <?php } ?>
                                        <th>Amount Paid</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 

                                    DynamicFormWidget::begin([
                                        'widgetContainer' => 'dynamicform_wrapper_1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-items-1', // required: css class selector
                                        'widgetItem' => '.item-1', // required: css class
                                        'limit' => count($payment_category_arry), // the maximum times, an element can be cloned (default 999)
                                        'insertButton' => '.add-item-1', // css class
                                        'deleteButton' => '.remove-item-1', // css class
                                        'min' => count($payment_category_arry), // 0 or 1 (default 1)
                                        'model' => $modelsPaymentProject[0],
                                        'formId' => 'dynamic-form-1',
                                        'formFields' => [
                                            'business_id',
                                            'paid_amount',
                                            'payable_or_check_id',
                                        ],
                                    ]); 

                                    
                                        $no = 0;

                                        echo "<div class='container-items-1'>";
                                    
                                            foreach ($modelsPaymentProject as $i => $modelsPaymentProject): 

                                                foreach ($payment_category_arry as $p_id) {
                                                    $p_id = (int)$p_id;
                                                    if($payment_category_arry == $payable_ids_arry){
                                                        $due_date = TblPayable::find()->where(['payable_id' => $p_id])->one()->due_date;
                                                        $project_id = TblPayable::find()->where(['payable_id' => $p_id])->one()->project_id;
                                                        $payable_amount = TblPayable::find()->where(['payable_id' => $p_id])->one()->payable_amount;
                                                        $paid_payable_amount = TblPayable::find()->where(['payable_id' => $p_id])->one()->paid_payable_amount;
                                                        $amount_balance = $payable_amount - $paid_payable_amount;
                                                    }
                                                    else if($payment_category_arry == $cheque_ids_arry){
                                                        $due_date = PostDatedCheque::find()->where(['id' => $p_id])->one()->cheque_date;
                                                        $project_id = PostDatedCheque::find()->where(['id' => $p_id])->one()->business_id;
                                                        $chq_amount = PostDatedCheque::find()->where(['id' => $p_id])->one()->chq_amount;
                                                        $paid_chq_amount = PostDatedCheque::find()->where(['id' => $p_id])->one()->paid_chq_amount;
                                                        $amount_balance = $chq_amount - $paid_chq_amount;
                                                    }
                                                    $project_name = AccBusiness::find()->where(['business_id' => $project_id])->one()->business_name;
                                                    
                                                    echo "<tr class='item-1'>";
                                                    echo "<td>".$p_id."</td>";
                                                    echo "<td>".$due_date."</td>";
                                                    echo "<td>".$project_name."</td>";
                                                    echo "<td>".number_format((float)$amount_balance, 2, '.', ',')."</td>";
                                                    
                                                    echo $form->field($modelsPaymentProject, "[{$no}]business_id")->hiddenInput(['value' => $project_id])->label(false);
                                                    echo "<td>".$form->field($modelsPaymentProject, "[{$no}]paid_amount")->textInput(['placeholder' => 'Amount'])->label(false)."</td>";
                                                    echo $form->field($modelsPaymentProject, "[{$no}]payable_or_check_id")->hiddenInput(['value' => $p_id])->label(false);

                                                    echo "</tr>";
                                                    $no += 1;
                                                }
                                                ?>
                                            
                                            <?php endforeach; ?>

                                        </div>

                                    <?php DynamicFormWidget::end(); ?>
                            
                                </tbody>
                            </table>

                        </div>

                    <?php } ?>
                    
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="panel panel-default">
                <!--div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Receipt Items</h4></div-->
                    <div class="panel-body">
                         <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $modelsPmtItems[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'chart_of_acc_id',
                                'pmt_detail_desc',
                                //'quantity',
                                //'unit_price',
                                'line_total',
                            ],
                        ]); ?>

                        <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($modelsPmtItems as $i => $modelsPmtItems): ?>
                            <div class="item panel panel-default">

                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (! $modelsPmtItems->isNewRecord) {
                                            echo Html::activeHiddenInput($modelsPmtItems, "[{$i}]pmt_detail_id");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-2 payment-create-category">
                                            <?php

                                            echo $form->field($modelsPmtItems, "[{$i}]coa_category")->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(CaGroup::find()->andWhere(['=','ca_level', 1])->all(), 'id', 'item_name'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Category', 'class' => 'acc-payment-main-create-category'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);

                                            ?>
                                            <a href="index.php?r=cagroup/dashboard" target="_blank" title="Create New Chart of Account Item"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                        </div>
                                        <div class="col-sm-3 suspense">
                                            <?php
                                            echo $form->field($modelsPmtItems, "[{$i}]chart_of_acc_id")->widget(DepDrop::classname(), [
                                                'language' => 'en',
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'options' => ['placeholder' => 'Suspense'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'depends'=>['accpaymentdetail-'.$i.'-coa_category'],
                                                    'url'=>Url::to(['/journalmain/select-coa-list']),
                                                    'loadingText' => 'Loading ...',
                                                ],
                                            ])->label(false);
                                            ?>
                                        </div>

                                        <div class="col-sm-2">
                                            <?= $form->field($modelsPmtItems, "[{$i}]subcontractor")->widget(DepDrop::classname(),
                                                [
                                                    'language' => 'en',
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'pluginOptions' => [
                                                        'allowClear'=>true,
                                                        'depends'=>['accpaymentdetail-'.$i.'-chart_of_acc_id'],
                                                        'placeholder'=>'Sub Contractor',
                                                        'url'=>Url::to(['/accpaymentmain/select-subcontractor']),
                                                        'loadingText' => 'Loading ...',
                                                    ],
                                                ])->label(false);
                                            ?>

                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <?= $form->field($modelsPmtItems, "[{$i}]pmt_detail_desc")->textInput(['maxlength' => true,'placeholder'=>'Description'])->label(FALSE) ?>
                                        </div>
                                        <!--div class="col-sm-2">
                                            <?= $form->field($modelsPmtItems, "[{$i}]quantity")->textInput(['maxlength' => true,'placeholder'=>'Quantity'])->label(FALSE) ?>
                                            </div-->
                                        <!--div class="col-sm-2">
                                            <?= $form->field($modelsPmtItems, "[{$i}]unit_price")->textInput(['maxlength' => true,'placeholder'=>'Unit Price'])->label(FALSE) ?>
                                        </div-->
                                        <div class="col-sm-2 width-150">
                                            <?= $form->field($modelsPmtItems, "[{$i}]line_total")->textInput(['maxlength' => true,'placeholder'=>'Amount', 'class' => 'form-control text-right'])->label(FALSE) ?>
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

