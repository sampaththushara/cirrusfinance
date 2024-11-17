<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblPayable */

$this->title = 'Create New Payable';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Payables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payable";
?>
<div class="tbl-payable-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
