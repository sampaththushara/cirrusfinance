<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Journaldetail */

$this->title = 'Update Journaldetail: ' . $model->journal_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Journaldetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->journal_detail_id, 'url' => ['view', 'id' => $model->journal_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="journaldetail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
