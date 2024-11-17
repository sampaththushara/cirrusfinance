<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReceivableCategory */

$this->title = 'Update Receivable Category: ' . $model->Receivable_Cat_ID;
$this->params['breadcrumbs'][] = ['label' => 'Receivable Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Receivable_Cat_ID, 'url' => ['view', 'id' => $model->Receivable_Cat_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="receivable-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
