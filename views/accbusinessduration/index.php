<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccBusinessDurationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Accounting Duration';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-business-duration-index">

   <!--  <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <div class="panel">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="panel-body">

            <p>
                <?= Html::a('Create Project Accounting Duration', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'duration_id',
                    'business_from',
                    'business_to',
                    'business.business_name',
                    'duration_status',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
