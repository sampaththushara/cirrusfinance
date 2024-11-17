<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccEntryMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acc Entry Mains';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-entry-main-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Acc Entry Main', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'entry_id',
            'ref_no',
            'entry_date',
            'dr_total',
            'cr_total',
            //'narration',
            //'business_id',
            //'entry_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
