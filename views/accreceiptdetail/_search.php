<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-receipt-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rpt_detail_id') ?>

    <?= $form->field($model, 'chart_of_acc_id') ?>

    <?= $form->field($model, 'rpt_detail_desc') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'line_total') ?>

    <?php // echo $form->field($model, 'rpt_main_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
