<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AccBusiness;
use app\models\PayerMaster;
use app\models\ReceivableCategory;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\Typeahead;

/* @var $this yii\web\View */
/* @var $model app\models\TblReceivable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-receivable-form admin-form theme-primary mw1000 center-block">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
          <span> <?= $this->title; ?> </span>
        </div>

        <div class="row">   
            <div class="col-sm-3">



                <?php 
                echo $form->field($model, 'period_from')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'From'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                
                ?>

            </div>   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'period_to')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'to'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?php 
                echo $form->field($model, 'due_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Due Date'],
                    'pluginOptions'=>[
                        'todayHighlight' => true,
                        'todayBtn' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])->label(FALSE);
                
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?php 
                echo $form->field($model, 'project_id')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(AccBusiness::find()->andWhere(['status'=>1])->all(), 'business_id', 'business_name'),
                    'options' => ['placeholder' => 'Select project'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Project');
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?php 

                $data = array();
                $payer_names = PayerMaster::find()->all();
                foreach ($payer_names as $payer) {
                    array_push($data, $payer->payer_name);
                }

                if(empty($data)){
                    array_push($data, " ");
                }
 
                // Usage with ActiveForm and model (with search term highlighting)
                echo "<label> Payer Name </label>";
                echo Typeahead::widget([
                    'name' => 'payer_name',
                    'options' => ['placeholder' => 'Filter as you type ...'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'local' => $data,
                            'limit' => 10
                        ]
                    ]
                ]);
                ?>
                <br>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?php 
                echo $form->field($model, 'receivable_amount')->textInput(['class' => 'form-control']);
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?php 
                echo $form->field($model, 'receivable_category')->widget(Select2::classname(), [
                    'data'=>ArrayHelper::map(ReceivableCategory::find()->all(), 'Receivable_Cat_ID', 'Receivable_Category'),
                    'options' => ['placeholder' => 'Select Receivable Category'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Receivable Category');
                ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?= $form->field($model, 'receivable_description')->textInput(['maxlength' => true]) ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-6">

                <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>

            </div>
        </div>

        <div class="row">   
            <div class="col-sm-3">

                <?php 
                echo $form->field($model, 'receivable_status')->widget(Select2::classname(), [
                    'data'=> ['Not Receipt' => 'Not Receipt', 'Receipt' => 'Receipt'],
                    'options' => ['value' => 'Not Received'],
                    'pluginOptions'=>[
                        'allowClear' => true
                    ]
                ])->label('Receivable Status');
                ?>

            </div>
        </div>

        <hr class="short alt">

        <div class="form-group">
            <div class="bs-component">
                <div class="col-lg-7 col-xs-12">
                    <div class="bs-component">
                        <div class="col-lg-3 pull-right">   
                            <?= Html::submitButton('Save', ['class' => 'btn btn-rounded btn-primary btn-block']) ?>
                        </div>
                    </div>
                </div>  

            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
