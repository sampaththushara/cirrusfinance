<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubcontractorBills */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subcontractor-bills-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'page_id')->textInput() ?>

    <?= $form->field($model, 'payee_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'bill_date')->textInput() ?>

    <?= $form->field($model, 'business_id')->textInput() ?>

    <?= $form->field($model, 'received_date')->textInput() ?>

    <?= $form->field($model, 'bill_status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
