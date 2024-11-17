<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccBankAccount */

$this->title = 'Create Acc Bank Account';
$this->params['breadcrumbs'][] = ['label' => 'Acc Bank Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-bank-account-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
