<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptMain */

$this->title = 'Add New Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receipt";
?>
<div class="acc-receipt-main-create">

    <!--h3><?= Html::encode($this->title) ?></h3-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelsRptItem' => $modelsRptItem,
        'ca_data' => $ca_data,
        'account_type' => $account_type,
    ]) ?>

</div>
