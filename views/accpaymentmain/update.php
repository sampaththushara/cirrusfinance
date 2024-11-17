<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccPaymentMain */

$this->title = 'Update Acc Payment Main: ' . $model->pmt_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Payment Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pmt_id, 'url' => ['view', 'id' => $model->pmt_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "payment";
?>
<div class="acc-payment-main-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPmtItems' => $modelsPmtItems,
        'ca_data' => $ca_data,
        'modelsPaymentProject' => $modelsPaymentProject,
        'modelOnePaymentProject' => $modelOnePaymentProject,
    ]) ?>

</div>
