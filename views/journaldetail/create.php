<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Journaldetail */

$this->title = 'Create Journaldetail';
$this->params['breadcrumbs'][] = ['label' => 'Journaldetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journaldetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
