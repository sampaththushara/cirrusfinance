<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JournalmainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journalmain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'journal_id') ?>

    <?= $form->field($model, 'reference_no') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'tot_journal_amount') ?>

    <?= $form->field($model, 'added_by') ?>

    <?php // echo $form->field($model, 'added_date') ?>

    <?php // echo $form->field($model, 'business_id') ?>

    <?php // echo $form->field($model, 'business_duration_id') ?>

    <?php // echo $form->field($model, 'journal_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
