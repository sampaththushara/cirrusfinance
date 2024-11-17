<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDuration */

$this->title = $model->duration_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Business Durations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-business-duration-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->duration_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->duration_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'duration_id',
            'business_from',
            'business_to',
            'business_id',
            'duration_status',
        ],
    ]) ?>

</div>
