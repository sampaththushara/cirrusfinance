<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VehicleTransaction */

$this->title = 'Update Vehicle Transaction: ' . $model->vehicle_transaction_id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicle Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehicle_transaction_id, 'url' => ['view', 'id' => $model->vehicle_transaction_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehicle-transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
