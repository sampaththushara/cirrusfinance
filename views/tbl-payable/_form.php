<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AccBusiness;
use app\models\PayeeMaster;
use app\models\ExpenseMaster;
use app\models\Vehicles;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\Typeahead;

/* @var $this yii\web\View */
/* @var $model app\models\TblPayable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-payable-form admin-form theme-primary mw1000 center-block">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <div class="row">   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'period_from')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'From'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                ?>

            </div>   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'period_to')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'to'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                ?>

            </div> 
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'due_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Due Date'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                ?>

            </div>
        </div>


        <div class="row">   
            <div class="col-sm-9">

                <?php 
                echo $form->field($model, 'project_id')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(AccBusiness::find()->andWhere(['status'=>1])->all(), 'business_id', 'business_name'),
                    'options' => ['placeholder' => 'Select project'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Project');
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-9">

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
                echo "<label> Payee Name </label>";
                echo Typeahead::widget([
                    'name' => 'payee_name',
                    'options' => ['placeholder' => 'Filter as you type ...'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'local' => $data,
                            'limit' => 10
                        ]
                    ]
                ]);
                ?>
                <br>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-9">

                <?php echo $form->field($model, 'payable_amount')->textInput(['class' => 'form-control']); ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'expense_category')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(ExpenseMaster::find()->all(), 'exp_id', 'expense_category'),
                    'options' => ['placeholder' => 'Select Expense Category'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Expense Category');
                ?>

            </div>
            <div class="col-sm-3">

                <?php
                echo $form->field($model, 'vehicle_number')->widget(DepDrop::classname(), [
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['tblpayable-expense_category'],
                        'url' => Url::to(['tbl-payable/get-vehicle']),
                        'loadingText' => 'Loading ...',
                        //'initialize'=> true,
                    ]
                ]);
                ?> 

            </div>
            <div class="col-sm-3">

                <?php
                echo $form->field($model, 'vehicle_expense_category')->widget(DepDrop::classname(), [
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['tblpayable-expense_category'],
                        'url' => Url::to(['tbl-payable/get-vehicle-expense-category']),
                        'loadingText' => 'Loading ...',
                        //'initialize'=> true,
                    ]
                ]);
                ?> 

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-9">

                <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-9">

                <?= $form->field($model, 'added_by')->textInput(['maxlength' => true, 'class' => 'form-control']); ?>

            </div>
        </div>

        <!-- <div class="row">   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'payable_status')->widget(Select2::classname(), [
                    'data'=> ['Not Paid' => 'Not Paid', 'Paid' => 'Paid'],
                    'options' => ['value' => 'Not Paid'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Payable Status');
                ?>

            </div>
        </div> -->

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

    </div>

    <?php ActiveForm::end(); ?>

</div>
