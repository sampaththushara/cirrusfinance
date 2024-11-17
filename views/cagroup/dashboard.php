<?php

use yii\helpers\Html;
use yii\grid\GridView;


use kartik\tree\TreeView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CaGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chart of Accounts';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "coa";
?>




<div class="ca-group-index">

<div id="default-tree"></div>

<h2 class="text-dark mbn confirmation-header"><i class="fa fa-check text-success"></i> <?= Html::encode($this->title) ?></h2><br>
           

    <?php echo $html_bal_sheet;?>

    <?php echo $html_profit_loss;?>

</div>


