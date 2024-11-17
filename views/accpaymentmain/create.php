<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccPaymentMain */

$this->title = 'Create New Payment';
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payment";
?>
<div class="acc-payment-main-create center-block" style="margin: auto;">

    
    <?= $this->render('_form', [
        'model' => $model,
        'modelsPmtItems' => $modelsPmtItems,
        'ca_data' => $ca_data,
        'modelsPaymentProject' => $modelsPaymentProject,
        'modelOnePaymentProject' => $modelOnePaymentProject,
    ]) ?>

</div>
