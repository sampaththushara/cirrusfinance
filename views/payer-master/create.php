<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PayerMaster */

$this->title = 'Create Payer';
$this->params['breadcrumbs'][] = ['label' => 'Payer Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="payer-master-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
