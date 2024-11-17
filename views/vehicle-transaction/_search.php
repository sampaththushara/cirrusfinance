<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleTransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'vehicle_transaction_id') ?>

    <?= $form->field($model, 'vehicle_id') ?>

    <?= $form->field($model, 'vehicle_exp_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'added_by') ?>

    <?php // echo $form->field($model, 'added_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
