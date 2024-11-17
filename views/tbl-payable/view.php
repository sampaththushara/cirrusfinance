<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblPayable */

$this->title = $model->payable_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Payables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payable";
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-payable-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->payable_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->payable_id], [
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
            'payable_id',
            'project_id',
            'due_date',
            'payee_id',
            'description',
            'expense_category',
            'period_from',
            'period_to',
            'added_date',
            'added_by',
            'payable_status',
        ],
    ]) ?>

</div>
