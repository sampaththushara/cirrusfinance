<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptDetail */

$this->title = $model->rpt_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-receipt-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rpt_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rpt_detail_id], [
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
            'rpt_detail_id',
            'chart_of_acc_id',
            'rpt_detail_desc',
            'quantity',
            'unit_price',
            'line_total',
            'rpt_main_id',
        ],
    ]) ?>

</div>
