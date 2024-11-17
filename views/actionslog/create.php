<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TblActionsLog */

$this->title = 'Create Tbl Actions Log';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Actions Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-actions-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
