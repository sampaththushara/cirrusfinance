<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccBusinessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="panel">

    <h1></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="panel-body">

            <p>
                <?= Html::a('Create New Project', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            </p>

            <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'business_id',
                    'business_name',
                    'status',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
