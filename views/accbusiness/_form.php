<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusiness */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
            <span class="panel-title"><?= Html::encode($this->title) ?></span>
        </div>

        <?php $form = ActiveForm::begin( ['options' => ['class' => 'form-horizontal']] ); ?>

        <!--?= $form->field($model, 'business_id')->textInput() ?-->

        <div class="form-group">  
            <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Project Name</label>

            <div class="bs-component">
                <div class="col-lg-5 col-xs-12">
                    <div class="bs-component">                          
                        <?= $form->field($model, 'business_name')->textInput(['maxlength' => true])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>

         <div class="form-group">  
            <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Status</label>

            <div class="bs-component">
                <div class="col-lg-5 col-xs-12">
                    <div class="bs-component">                          
                        <?= $form->field($model, 'status')->widget(Select2::classname(), [
                            'data' => ['1'=>'ACTIVE','0'=>'DEACTIVE'],
                            'options' => ['placeholder' => 'Please Select ...'],
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>

        <hr class="short alt">

       <div class="form-group">
            <div class="bs-component">
                <div class="col-lg-7 col-xs-12">
                    <div class="bs-component">
                        <div class="col-lg-3 col-xs-3 pull-right">  
                            <?= Html::submitButton('Save', ['class' => 'btn btn-rounded btn-primary btn-block']) ?>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        
        <?php ActiveForm::end(); ?>

    </div>

</div>


