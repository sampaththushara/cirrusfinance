<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use app\models\AccBusiness;
use app\models\PayeeMaster;
use yii\helpers\Url;
use kartik\widgets\Typeahead;

/* @var $this yii\web\View */
/* @var $model app\models\PostDatedCheque */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-dated-cheque-form admin-form theme-primary mw1000 center-block">

    <?php $form = ActiveForm::begin(); ?>
    

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

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

        <?= $form->field($model, 'cheque_no')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'chq_amount')->textInput(['maxlength' => true]) ?>

        <?php
            echo $form->field($model, "cheque_date")->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Cheque dated'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
            ]);
        ?>   

        <?php
            echo $form->field($model, "received_date")->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Issued date'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
            ]);
        ?>

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
        echo $form->field($model, 'customer_name')->widget(Typeahead::classname(),[
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

        <?= $form->field($model, 'chq_description')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <div class="bs-component">
                <div class="col-lg-7 col-xs-12">
                    <div class="bs-component">
                        <div class="col-lg-3 col-xs-3 pull-right">  
                            <?= Html::submitButton('Save', ['class' => 'btn btn-rounded btn-primary btn-block']) ?>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>
