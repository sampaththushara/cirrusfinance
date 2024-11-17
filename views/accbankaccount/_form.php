<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\AccBusiness;
use app\models\AccAccountTypes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\AccBankAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-bank-account-form">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>

            <?php $form = ActiveForm::begin( ['options' => ['class' => 'form-horizontal']] ); ?>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Account ID</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'account_id')->textInput()->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Account Name</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'account_name')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Account Code</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'account_code')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                    <div class="col-lg-3 pl3">
                      <span class="help-block mt3"><i class="fa fa-bell"></i> Account Code is optional</span>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Credit Limit</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'credit_limit')->textInput()->label(false) ?>
                        </div>
                    </div>
                    <div class="col-lg-3 pl3">
                      <span class="help-block mt3"><i class="fa fa-bell"></i> Credit Limit is optional</span>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Account Status</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">                          
                            <?= $form->field($model, 'account_status')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                    <div class="col-lg-3 pl3">
                      <span class="help-block mt3"><i class="fa fa-bell"></i> Account Status is optional</span>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Project</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">   
                            <?php
                             echo $form->field($model, "business_id")->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(AccBusiness::find()->all(), 'business_id', 'business_name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Project'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3 pl3">
                      <span class="help-block mt3"><i class="fa fa-bell"></i> Project is optional</span>
                    </div>
                </div>
            </div>

            <div class="form-group">  
                <label for="inputInline" class="col-lg-2 col-xs-12 control-label">Account Type</label>

                <div class="bs-component">
                    <div class="col-lg-5 col-xs-12">
                        <div class="bs-component">   
                            <?php
                             echo $form->field($model, "account_type_id")->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(AccAccountTypes::find()->all(), 'type_id', 'type_name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Account Type'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                            ?>
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