<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicles-form admin-form theme-primary mw1000 center-block">

    <div class="panel-body bg-light">
        <div class="section-divider mt20 mb40">
            <span> <?= $this->title; ?> </span>            
        </div>

	    <?php $form = ActiveForm::begin(); ?>

        <div class="section row">   
        	<div class="col-md-6"> 
			    <?= $form->field($model, 'vehicle_number')->textInput(['maxlength' => true]) ?>
			</div>
		</div>

        <div class="section row">   
        	<div class="col-md-6"> 
			    <?= $form->field($model, 'added_by')->textInput(['maxlength' => true]) ?>
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

	    <?php ActiveForm::end(); ?>

	</div>

</div>
