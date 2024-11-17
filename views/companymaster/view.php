<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Company Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
\yii\web\YiiAsset::register($this);
?>
<div class="company-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_legal_name',
            'company_reg_no',
            'incorporation_date',
            'financial_year',
            'tin_no',
            'vat_svat_no',
            'nbt_reg_no',
            'epf_etf_reg_no',
            'payee_tax_no',
            'address',
            'image',
        ],
    ]) ?>

</div>
