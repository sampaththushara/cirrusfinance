<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */

$this->title = 'Update Vehicles: ' . $model->vehicle_id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vehicle_id, 'url' => ['view', 'id' => $model->vehicle_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehicles-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
