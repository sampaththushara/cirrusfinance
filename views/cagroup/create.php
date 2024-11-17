<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Create Ca Group';
$this->params['breadcrumbs'][] = ['label' => 'Ca Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "coa";
?>
<div class="ca-group-create">
    
    <?= $this->render('_form', [
        'model' => $model,'parent' =>$parent
    ]) ?>

</div>
