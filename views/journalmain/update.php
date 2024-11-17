<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Journalmain */

$this->title = 'Update Journalmain: ' . $model->journal_id;
$this->params['breadcrumbs'][] = ['label' => 'Journalmains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->journal_id, 'url' => ['view', 'id' => $model->journal_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "journal";
?>
<div class="journalmain-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsJournalItems' => $modelsJournalItems,
        'ca_data' => $ca_data,
    ]) ?>

</div>
