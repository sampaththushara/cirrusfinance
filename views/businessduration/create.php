<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDuration */

$this->title = 'Create Acc Business Duration';
$this->params['breadcrumbs'][] = ['label' => 'Acc Business Durations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-business-duration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
