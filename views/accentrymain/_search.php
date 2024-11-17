<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccEntryMainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-entry-main-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'entry_id') ?>

    <?= $form->field($model, 'ref_no') ?>

    <?= $form->field($model, 'entry_date') ?>

    <?= $form->field($model, 'dr_total') ?>

    <?= $form->field($model, 'cr_total') ?>

    <?php // echo $form->field($model, 'narration') ?>

    <?php // echo $form->field($model, 'business_id') ?>

    <?php // echo $form->field($model, 'entry_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
