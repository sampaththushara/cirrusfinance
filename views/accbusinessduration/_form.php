<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccBusinessDuration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-business-duration-form">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>

            <?php $form = ActiveForm::begin( ['options' => ['class' => 'form-horizontal']] ); ?>

            <!--?= $form->field($model, 'duration_id')->textInput() ?-->

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">From</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'business_from')->textInput()->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">To</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'business_to')->textInput()->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Business ID</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'business_id')->textInput()->label(false) ?>
                        </div>
                    </div>
                    <div class="col-lg-3 pl3">
                      <span class="help-block mt3"><i class="fa fa-bell"></i> Business ID is optional</span>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Duration Status</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'duration_status')->textInput()->label(false) ?>
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

</div>
