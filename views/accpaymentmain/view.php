<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccPaymentMain */

$this->title = $model->pmt_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Payment Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payment";
\yii\web\YiiAsset::register($this);
?>
<div class="acc-payment-main-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pmt_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pmt_id], [
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
            'pmt_id',
            'reference_no',
            'account_id',
            'payee_name',
            'description',
            'tot_payment_amount',
            'added_by',
            'added_date',
            'business_duration_id',
            'payment_date',
        ],
    ]) ?>

</div>
