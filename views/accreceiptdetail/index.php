<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccReceiptDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acc Receipt Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-receipt-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Acc Receipt Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rpt_detail_id',
            'chart_of_acc_id',
            'rpt_detail_desc',
            'quantity',
            'unit_price',
            //'line_total',
            //'rpt_main_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
