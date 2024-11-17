<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccCashAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-cash-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'account_name') ?>

    <?= $form->field($model, 'account_code') ?>

    <?= $form->field($model, 'account_status') ?>

    <?= $form->field($model, 'business_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
