<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptDetail */

$this->title = 'Update Acc Receipt Detail: ' . $model->rpt_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rpt_detail_id, 'url' => ['view', 'id' => $model->rpt_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acc-receipt-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
