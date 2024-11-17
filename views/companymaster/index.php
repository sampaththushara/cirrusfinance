<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanyMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company Master';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="panel">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Company Master', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
    </p>

<div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'company_legal_name',
            'company_reg_no',
            'incorporation_date',
            'financial_year',
            //'tin_no',
            //'vat_svat_no',
            //'nbt_reg_no',
            //'epf_etf_reg_no',
            //'payee_tax_no',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
