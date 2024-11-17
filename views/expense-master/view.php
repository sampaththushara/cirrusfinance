<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseMaster */

$this->title = $model->exp_id;
$this->params['breadcrumbs'][] = ['label' => 'Expense Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "admin";
\yii\web\YiiAsset::register($this);
?>
<div class="expense-master-view  admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->exp_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->exp_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'exp_id',
                'expense_category',
                'expense_status',
            ],
        ]) ?>

    </div>

</div>
