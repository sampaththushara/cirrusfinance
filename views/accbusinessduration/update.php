<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDuration */

$this->title = 'Update Acc Business Duration: ' . $model->duration_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Business Durations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->duration_id, 'url' => ['view', 'id' => $model->duration_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-business-duration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
