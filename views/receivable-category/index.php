<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReceivableCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receivable Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receivable-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Receivable Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Receivable_Cat_ID',
            'Receivable_Category',
            'Cat_Status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
