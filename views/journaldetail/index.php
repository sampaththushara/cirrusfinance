<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JournaldetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Journaldetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journaldetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Journaldetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'journal_detail_id',
            'chart_of_acc_id',
            'journal_detail_desc',
            'quantity',
            'unit_price',
            //'line_total',
            //'journal_main_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
