<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblActionsLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Actions Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-actions-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Actions Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'index_no',
            'student_id',
            'action_summary',
            'action_taken',
            //'added_by',
            //'added_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
