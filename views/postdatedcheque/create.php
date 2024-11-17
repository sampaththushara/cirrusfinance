<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostDatedCheque */

$this->title = 'Post Dated Cheque';
$this->params['breadcrumbs'][] = ['label' => 'Post Dated Cheques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-dated-cheque-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
