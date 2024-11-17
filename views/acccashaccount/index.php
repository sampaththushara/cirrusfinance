<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccCashAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acc Cash Accounts';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-cash-account-index">

    <!-- <h1></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="panel-body">

            <p>
                <?= Html::a('Create Acc Cash Account', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'account_id',
                    'account_name',
                    'account_code',
                    'account_status',
                    'business_id',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

    </div>
    
</div>
