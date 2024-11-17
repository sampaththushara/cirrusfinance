<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccEntryMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-entry-main-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ref_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entry_date')->textInput() ?>

    <?= $form->field($model, 'dr_total')->textInput() ?>

    <?= $form->field($model, 'cr_total')->textInput() ?>

    <?= $form->field($model, 'narration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_id')->textInput() ?>

    <?= $form->field($model, 'entry_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
