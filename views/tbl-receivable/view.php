<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblReceivable */

$this->title = $model->receivable_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Receivables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receivable";
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-receivable-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->receivable_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->receivable_id], [
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
            'receivable_id',
            'project_id',
            'due_date',
            'payer_id',
            'receivable_description',
            'receivable_category',
            'period_from',
            'period_to',
            'added_date',
            'added_by',
            'receivable_status',
        ],
    ]) ?>

</div>
