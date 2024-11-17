<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMain */

$this->title = 'Update Acc Receipt Main: ' . $model->rpt_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rpt_id, 'url' => ['view', 'id' => $model->rpt_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "receipt";
?>
<div class="acc-receipt-main-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
