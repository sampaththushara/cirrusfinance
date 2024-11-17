<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-receipt-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rpt_detail_id')->textInput() ?>

    <?= $form->field($model, 'chart_of_acc_id')->textInput() ?>

    <?= $form->field($model, 'rpt_detail_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'unit_price')->textInput() ?>

    <?= $form->field($model, 'line_total')->textInput() ?>

    <?= $form->field($model, 'rpt_main_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
