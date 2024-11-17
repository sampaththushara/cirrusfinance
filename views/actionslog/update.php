<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblActionsLog */

$this->title = 'Update Tbl Actions Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Actions Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-actions-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
