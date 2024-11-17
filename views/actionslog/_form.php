<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblActionsLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-actions-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'index_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'action_summary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action_taken')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'added_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
