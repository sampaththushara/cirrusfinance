<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehicleExpenseMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicle Expense Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-expense-master-index admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Vehicle Expense Master', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
        </p>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'vehicle_exp_id',
                'vehicle_expense_category',
                'expense_status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>

</div>
