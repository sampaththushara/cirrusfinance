<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleExpenseMaster */

$this->title = 'Update Vehicle Expense Master: ' . $model->vehicle_exp_id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Expense Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehicle_exp_id, 'url' => ['view', 'id' => $model->vehicle_exp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehicle-expense-master-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
