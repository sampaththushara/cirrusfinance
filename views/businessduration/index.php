<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccBusinessDurationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acc Business Durations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-business-duration-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Acc Business Duration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'duration_id',
            'business_from',
            'business_to',
            'business_id',
            'duration_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
