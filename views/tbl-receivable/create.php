<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblReceivable */

$this->title = 'Create Receivable';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Receivables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receivable";
?>
<div class="tbl-receivable-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
