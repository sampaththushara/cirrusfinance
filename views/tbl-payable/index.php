<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblPayableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payables';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payable";
?>
<div class="tbl-payable-index admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Payable', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            
            <?= Html::a('Outstanding Payments', ['outstanding-payments'], ['class' => 'btn btn-rounded btn-primary']) ?>
        </p>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'payable_id',
                [
                    'label' => 'Project',
                    'attribute' => 'project_name',
                    'value' => 'project.business_name',
                ],
                'due_date',
                [
                    'label' => 'Payee Name',
                    'attribute' => 'payee_name',
                    'value' => 'payee.payee_name',
                ],
                'payable_amount',
                'description',
                //'expense_category',
                //'period_from',
                //'period_to',
                //'added_date',
                //'added_by',
                //'payable_status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
    
</div>
