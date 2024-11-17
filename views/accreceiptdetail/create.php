<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccReceiptDetail */

$this->title = 'Create Acc Receipt Detail';
$this->params['breadcrumbs'][] = ['label' => 'Acc Receipt Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-receipt-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
