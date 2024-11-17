<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Journalmain */

$this->title = 'Create Journal Entry';
$this->params['breadcrumbs'][] = ['label' => 'Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "journal";
?>

<div class="journalmain-create center-block" style="margin: auto;">

    <!--h1><?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsJournalItems' => $modelsJournalItems,
        'ca_data' => $ca_data,
        'error_msg'=> $error_msg
    ]) ?>

</div>
