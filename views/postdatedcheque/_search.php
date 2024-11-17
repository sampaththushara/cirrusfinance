<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostDatedChequeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-dated-cheque-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cheque_no') ?>

    <?= $form->field($model, 'cheque_date') ?>

    <?= $form->field($model, 'received_date') ?>

    <?= $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'chq_description') ?>

    <?php // echo $form->field($model, 'chq_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
