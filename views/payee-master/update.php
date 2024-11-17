<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayeeMaster */

$this->title = 'Update Payee Master: ' . $model->payee_id;
$this->params['breadcrumbs'][] = ['label' => 'Payee Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->payee_id, 'url' => ['view', 'id' => $model->payee_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="payee-master-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
