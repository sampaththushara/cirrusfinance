<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccEntryMain */

$this->title = 'Update Acc Entry Main: ' . $model->entry_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Entry Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->entry_id, 'url' => ['view', 'id' => $model->entry_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acc-entry-main-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
