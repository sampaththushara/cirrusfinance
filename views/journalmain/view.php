<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Journalmain */

$this->title = $model->journal_id;
$this->params['breadcrumbs'][] = ['label' => 'Journalmains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "journal";
\yii\web\YiiAsset::register($this);
?>
<div class="journalmain-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->journal_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->journal_id], [
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
            'journal_id',
            'reference_no',
            'description',
            'tot_journal_amount',
            'added_by',
            'added_date',
            'business_id',
            'business_duration_id',
            'journal_date',
        ],
    ]) ?>

</div>
