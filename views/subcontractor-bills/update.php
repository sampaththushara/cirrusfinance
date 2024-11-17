<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubcontractorBills */

$this->title = 'Update Subcontractor Bills: ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Subcontractor Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'id' => $model->bill_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcontractor-bills-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
