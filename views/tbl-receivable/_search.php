<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblReceivableSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-receivable-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'receivable_id') ?>

    <?= $form->field($model, 'project_name') ?>

    <?= $form->field($model, 'due_date') ?>

    <?= $form->field($model, 'payer_name') ?>

    <?= $form->field($model, 'receivable_amount') ?>

    <?= $form->field($model, 'receivable_description') ?>

    <?php // echo $form->field($model, 'receivable_category') ?>

    <?php // echo $form->field($model, 'period_from') ?>

    <?php // echo $form->field($model, 'period_to') ?>

    <?php // echo $form->field($model, 'added_date') ?>

    <?php // echo $form->field($model, 'added_by') ?>

    <?php // echo $form->field($model, 'receivable_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
