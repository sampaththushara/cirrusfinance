<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccCashAccount */

$this->title = 'Create Acc Cash Account';
$this->params['breadcrumbs'][] = ['label' => 'Acc Cash Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-cash-account-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
