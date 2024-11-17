<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblReceivable */

$this->title = 'Update Receivable: ' . $model->receivable_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Receivables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->receivable_id, 'url' => ['view', 'id' => $model->receivable_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "receivable";
?>
<div class="tbl-receivable-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
