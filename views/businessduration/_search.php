<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDurationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-business-duration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'duration_id') ?>

    <?= $form->field($model, 'business_from') ?>

    <?= $form->field($model, 'business_to') ?>

    <?= $form->field($model, 'business_id') ?>

    <?= $form->field($model, 'duration_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
