<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-receipt-main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rpt_id') ?>

    <?= $form->field($model, 'reference_no') ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'payer_name') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'tot_receipt_amount') ?>

    <?php // echo $form->field($model, 'added_by') ?>

    <?php // echo $form->field($model, 'added_date') ?>

    <?php // echo $form->field($model, 'business_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
