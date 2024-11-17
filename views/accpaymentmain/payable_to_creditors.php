<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccPaymentMain;
use app\models\AccPaymentDetail;
use app\models\CaGroup;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Payable to Creditors';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

// if(isset($entered_date)){
// 	$value = $entered_date;
// }
// else{
// 	$value = date('d-M-Y', strtotime('+0 days'));
// }
?>

<div class="payable-to-creditors">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            
    		
	    	<!--form class="form-horizontal" name="date-form" action="index.php?r=accreceiptmain/trial-balance" method="post"-->

	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group row">
				    <label class="control-label col-sm-2" for="date">Payment Date:</label>
				    <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'entered_payment_date', 
							//'value' => $value,
							'options' => ['placeholder' => 'Payment Date', 'id' => 'payment-date'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>

				    <!-- <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'date_to', 
							//'value' => $value,
							'options' => ['placeholder' => 'To', 'id' => 'date-to'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div> -->
    
				</div>

				<div class="form-group row">
					<?php

				        echo '<div class="col-sm-2"><label class="control-label">Creditors :</label></div>';
						echo '<div class="col-sm-8">';
						echo Select2::widget([
						    'name' => 'creditors_ref',
						    'data' => ArrayHelper::map(AccPaymentMain::find()->all(),'reference_no','payee_name'),
						    'options' => [
						        'placeholder' => 'Select Creditors ...',
						        'multiple' => true,
						        'selected' => true,
						    ],
	                        'pluginOptions' => [
	                            'allowClear' => true,
	                        ],
						]);
						echo '</div>';
				    ?>    
				</div>

				<div class="form-group row">

	    			<div class="col-sm-2">
				        <?= Html::submitButton('Submit', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>
			<?php ActiveForm::end(); ?>

			<!-- Display Results -->
			<?php if(!empty($creditors_ref)){ ?>

				<p>
					<?php 
					$arry_data = array();
					array_push($arry_data, $entered_payment_date);
					array_push($arry_data, $creditors_ref);
					$arry_data = json_encode($arry_data);

					$url_encode = 'index.php?r=/accpaymentmain/payable-to-creditors-pdf&arry_data='.$arry_data;
	                ?>

	                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url_encode; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
	            </p>
				</div>



				<table class="table ">
					<thead>
						<tr>
							<th>#</th>
							<th>PO Ref.</th>
							<th>Project Ref.</th>
							<th>Amount</th>
							<th>No. of Days Outstanding</th>
						</tr>
					</thead>
					<tbody>

						<?php

						$serial_no = 1;

						foreach ($creditors_ref as $creditor_ref) {
							$payee_name = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->payee_name;
							$payment_date = AccPaymentMain::find()->where(['payee_name' => $payee_name])->one()->payment_date;
							$tot_payment_amount = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->tot_payment_amount;
							if(strtotime($payment_date) <= strtotime($entered_payment_date)){
								echo "<tr>";
								echo "<td>".$serial_no."</td>";
								echo "<td></td>";
								echo "<td>".$creditor_ref."</td>";
								echo "<td>".number_format((float)$tot_payment_amount, 2, '.', ',')."</td>";
								echo "<td>".round((strtotime($entered_payment_date) - strtotime($payment_date))/ (60 * 60 * 24))."</td>";
								echo "</tr>";
							}
							$serial_no += 1;
							
						}
						?>
						
					</tbody>
				</table>

			 <?php } ?>

		
     	</div>
    </div>

</div>
