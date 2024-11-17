<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_legal_name') ?>

    <?= $form->field($model, 'company_reg_no') ?>

    <?= $form->field($model, 'incorporation_date') ?>

    <?= $form->field($model, 'financial_year') ?>

    <?php // echo $form->field($model, 'tin_no') ?>

    <?php // echo $form->field($model, 'vat_svat_no') ?>

    <?php // echo $form->field($model, 'nbt_reg_no') ?>

    <?php // echo $form->field($model, 'epf_etf_reg_no') ?>

    <?php // echo $form->field($model, 'payee_tax_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
