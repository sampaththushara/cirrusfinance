<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayerMaster */

$this->title = 'Update Payer Master: ' . $model->payer_id;
$this->params['breadcrumbs'][] = ['label' => 'Payer Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->payer_id, 'url' => ['view', 'id' => $model->payer_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="payer-master-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
