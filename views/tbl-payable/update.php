<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblPayable */

$this->title = 'Update Payable: ' . $model->payable_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Payables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->payable_id, 'url' => ['view', 'id' => $model->payable_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "payable";
?>
<div class="tbl-payable-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
