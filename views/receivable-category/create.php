<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReceivableCategory */

$this->title = 'Create Receivable Category';
$this->params['breadcrumbs'][] = ['label' => 'Receivable Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receivable-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
