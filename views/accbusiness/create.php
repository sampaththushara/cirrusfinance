<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AccBusiness */

$this->title = 'Create New Project';
$this->params['breadcrumbs'][] = ['label' => 'Acc Businesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="acc-business-create">

    <!-- <h1></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
