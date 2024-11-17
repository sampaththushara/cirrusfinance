<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMain */

$this->title = "Receipt ID: ". $model->rpt_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receipt";
?>
<div class="acc-receipt-main-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--?= Html::a('Update', ['update', 'id' => $model->rpt_id], ['class' => 'btn btn-primary']) ?-->
        <!--?= Html::a('Delete', ['delete', 'id' => $model->rpt_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?-->

        <?= Html::a('<i class="fa far fa-hand-point-up"></i> Print Invoice', ['/accreceiptmain/receipt-pdf','id'=>$model->rpt_id], [
            'class'=>'btn btn-rounded btn-primary', 
            'target'=>'_blank', 
            'data-toggle'=>'tooltip', 
            'title'=>'Will open the generated PDF file in a new window'
        ]); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rpt_id',
            'reference_no',
            'account_id',
            'payer_name',
            'description',
            'tot_receipt_amount',
            'added_by',
            'added_date',
            'business_id',
        ],
    ]) ?>

</div>
