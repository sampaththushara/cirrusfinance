<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccEntryMain */

$this->title = 'Create Acc Entry Main';
$this->params['breadcrumbs'][] = ['label' => 'Acc Entry Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-entry-main-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
