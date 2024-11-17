<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostDatedChequeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Dated Cheques';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Post Dated Cheque', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
    </p>

<div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cheque_no',
            'chq_amount',
            'cheque_date',
            'received_date',
            'customer_name',
            'chq_description',
            //'chq_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
