<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Vehicles;
use app\models\VehicleExpenseMaster;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleTransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-transaction-form admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
            <span> <?= $this->title; ?> </span>            
        </div>

        <?php $form = ActiveForm::begin(); ?>

        <div class="section row">   
            <div class="col-md-6"> 
                <?php 
                echo $form->field($model, 'vehicle_id')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(Vehicles::find()->all(), 'vehicle_id', 'vehicle_number'),
                    'options' => ['placeholder' => 'Select vehicle'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Vehicle');
                ?>
            </div>
        </div>

        <div class="section row">   
            <div class="col-md-6"> 
                <?php 
                echo $form->field($model, 'vehicle_exp_id')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(VehicleExpenseMaster::find()->all(), 'vehicle_exp_id', 'vehicle_expense_category'),
                    'options' => ['placeholder' => 'Select vehicle expense master'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Vehicle Expense Master');
                ?>
            </div>
        </div>

        <div class="section row">   
            <div class="col-md-6"> 
                <?= $form->field($model, 'amount')->textInput() ?>
            </div>
        </div>

        <div class="section row">   
            <div class="col-md-6"> 
                <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>
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
