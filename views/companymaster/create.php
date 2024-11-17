<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyMaster */

$this->title = 'Create Company Master';
$this->params['breadcrumbs'][] = ['label' => 'Company Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
?>
<div class="company-master-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
