<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReceivableCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receivable-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Receivable_Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cat_Status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
