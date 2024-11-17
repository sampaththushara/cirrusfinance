<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Update Ca Group: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ca Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "coa";
?>
<div class="ca-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
