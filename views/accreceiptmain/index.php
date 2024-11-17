<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccReceiptMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' New Receipt';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receipt";
?>
<div class="acc-receipt-main-index  admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create New Bank Receipt', ['create'], ['class' => 'btn btn-rounded btn-primary']) ?>
            <?= Html::a('Create New Cash Receipt', ['create','type'=>'c'], ['class' =>' btn btn-rounded btn-primary']) ?>
            <!--?= Html::a('<i class="fa far fa-hand-point-up"></i> Print Invoice', ['/accreceiptmain/invoice'], [
                'class'=>'btn btn-rounded btn-primary', 
                'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated PDF file in a new window'
            ]); ?-->
        </p>
        <br>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'rpt_id',
                'reference_no',
                //'account_id',
                'payer_name',
                'description',
                'tot_receipt_amount',
                'receipt_date',
                //'added_by',
                //'added_date',
                //'business_id',

                //['class' => 'yii\grid\ActionColumn'],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',  //'{view} {update} {delete}'
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/accreceiptmain/receipt-pdf', 'id'=>$model->rpt_id], [
                                'target'=>'_blank', 
                                'data-toggle'=>'tooltip', 
                                'title'=>'Receipt'
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