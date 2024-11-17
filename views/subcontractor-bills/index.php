<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubcontractorBillsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcontractor Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcontractor-bills-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Subcontractor Bills', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bill_id',
            'page_id',
            'payee_name',
            'bill_amount',
            'bill_date',
            //'business_id',
            //'received_date',
            //'bill_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
