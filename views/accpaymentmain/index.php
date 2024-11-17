<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccPaymentMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payment";
?>
<div class="acc-payment-main-index admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <!-- <h1><?= Html::encode($this->title) ?></h1> -->
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create New Payment', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>        
       
            <?= Html::a('Post Dated Cheque', ['/postdatedcheque'], ['class' => 'btn btn-rounded btn-primary']) ?> 
        </p>
        <br>    	
    	
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'pmt_id',
                'reference_no',
                //'account_id',
                'payee_name',
                'description',
                'tot_payment_amount',
                //'added_by',
                //'added_date',
                //'business_id',
                //'business_duration_id',
                'payment_date',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',  //'{view} {update} {delete}'
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/accpaymentmain/payslip', 'id'=>$model->pmt_id], [
                                'target'=>'_blank', 
                                'data-toggle'=>'tooltip', 
                                'title'=>'Payment Slip'
                            ]);
                        },
                        /*'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['accreceiptmain/update', 'id'=>$model->rpt_id],['title' =>'Update']);
                        },*/
                        /*'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['accreceiptmain/delete', 'id'=>$model->rpt_id],['title' =>'Delete']);
                        }*/
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>