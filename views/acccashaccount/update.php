<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccCashAccount */

$this->title = 'Update Acc Cash Account: ' . $model->account_id;
$this->params['breadcrumbs'][] = ['label' => 'Acc Cash Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->account_id, 'url' => ['view', 'id' => $model->account_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-cash-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
