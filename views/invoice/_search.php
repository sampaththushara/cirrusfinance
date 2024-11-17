<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'invoice_id') ?>

    <?= $form->field($model, 'invoice_date') ?>

    <?= $form->field($model, 'client_name') ?>

    <?= $form->field($model, 'VAT') ?>

    <?= $form->field($model, 'NBT') ?>

    <?php // echo $form->field($model, 'business_id') ?>

    <?php // echo $form->field($model, 'bill_id') ?>

    <?php // echo $form->field($model, 'invoice_created_by') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
