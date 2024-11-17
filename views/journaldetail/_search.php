<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JournaldetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journaldetail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'journal_detail_id') ?>

    <?= $form->field($model, 'chart_of_acc_id') ?>

    <?= $form->field($model, 'journal_detail_desc') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'line_total') ?>

    <?php // echo $form->field($model, 'journal_main_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
