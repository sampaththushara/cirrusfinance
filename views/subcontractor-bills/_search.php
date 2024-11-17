<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubcontractorBillsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subcontractor-bills-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bill_id') ?>

    <?= $form->field($model, 'page_id') ?>

    <?= $form->field($model, 'payee_name') ?>

    <?= $form->field($model, 'bill_amount') ?>

    <?= $form->field($model, 'bill_date') ?>

    <?php // echo $form->field($model, 'business_id') ?>

    <?php // echo $form->field($model, 'received_date') ?>

    <?php // echo $form->field($model, 'bill_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
