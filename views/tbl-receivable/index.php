<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblReceivableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receivables';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receivable";
?>
<div class="tbl-receivable-index admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Receivable', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            
            <?= Html::a('Outstanding Receivables', ['outstanding-receivables'], ['class' => 'btn btn-rounded btn-primary']) ?>
        </p>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'receivable_id',
                [
                    'label' => 'Project',
                    'attribute' => 'project_name',
                    'value' => 'project.business_name',
                ],
                'due_date',
                [
                    'label' => 'Payer Name',
                    'attribute' => 'payer_name',
                    'value' => 'payer.payer_name',
                ],
                'receivable_amount',
                'receivable_description',
                //'receivable_category',
                //'period_from',
                //'period_to',
                //'added_date',
                //'added_by',
                //'receivable_status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
    
</div>
