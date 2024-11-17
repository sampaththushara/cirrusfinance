<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccBankAccount */

$this->title = 'Update Acc Bank Account: ' . $model->account_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->account_id, 'url' => ['view', 'id' => $model->account_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-bank-account-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
