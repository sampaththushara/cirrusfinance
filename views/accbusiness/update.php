<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusiness */

$this->title = 'Update Acc Business: ' . $model->business_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Businesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->business_id, 'url' => ['view', 'id' => $model->business_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-business-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
