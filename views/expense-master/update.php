<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseMaster */

$this->title = 'Update Expense Master: ' . $model->exp_id;
$this->params['breadcrumbs'][] = ['label' => 'Expense Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->exp_id, 'url' => ['view', 'id' => $model->exp_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="expense-master-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
