<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDuration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-business-duration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'duration_id')->textInput() ?>

    <?= $form->field($model, 'business_from')->textInput() ?>

    <?= $form->field($model, 'business_to')->textInput() ?>

    <?= $form->field($model, 'business_id')->textInput() ?>

    <?= $form->field($model, 'duration_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
