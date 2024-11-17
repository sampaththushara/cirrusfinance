<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="vehicles-index admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Vehicle', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
        </p>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'vehicle_id',
                'vehicle_number',
                'added_by',
                'added_date',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>

</div>
