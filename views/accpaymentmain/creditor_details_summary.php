<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccPaymentMain;
use app\models\AccPaymentDetail;
use app\models\CaGroup;
use app\models\SubcontractorBills;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Creditor Details Summary';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

// if(isset($entered_date)){
// 	$value = $entered_date;
// }
// else{
// 	$value = date('d-M-Y', strtotime('+0 days'));
// }
?>

<div class="creditor-details-summary">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            
    		
	    	<!--form class="form-horizontal" name="date-form" action="index.php?r=accreceiptmain/trial-balance" method="post"-->

	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group row">
				    <label class="control-label col-sm-2" for="date">As at:</label>
				    <div class="col-sm-4">
	      				<?php

	      				if(Yii::$app->request->post()){
	      					$date = $date_to;
	      				}
	      				else{
	      					$date = date('d-m-Y');
	      				}

	      				echo DatePicker::widget([
							'name' => 'date_to', 
							'value' => $date,
							'options' => ['placeholder' => 'To', 'id' => 'date-to'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>
    
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

				</div>

			<?php ActiveForm::end(); ?>

			<!-- Display Results -->
			<?php if(!empty($creditors_ref)){ ?>

				<hr>

				<p>
					<?php 
					$arry_data = array();
					array_push($arry_data, $date_to);
					array_push($arry_data, $creditors_ref);
					$arry_data = json_encode($arry_data);

					$url = 'index.php?r=/accpaymentmain/creditor-details-summary-pdf&arry_data='.$arry_data;
	                ?>

	                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
	            </p>



				<table class="table ">
					<thead>
						<tr>
							<th>#</th>
							<th>PO Ref.</th>
							<th>Project Ref.</th>
							<th>Bill Date</th>
							<th>Amount Payable</th>
							<th>Payments Made</th>
							<th>Days</th>
						</tr>
					</thead>
					<tbody>

						<?php

						$serial_no = 1;

						foreach ($creditors_ref as $creditor_ref) 
						{
							$payee_name = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->payee_name;
							$pmt_id = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->pmt_id;
							$po_reference = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->po_reference;

							if(SubcontractorBills::find()->where(['payee_name' => $payee_name])->one() !='')
							{
								$bill_date = SubcontractorBills::find()->where(['payee_name' => $payee_name])->one()->bill_date;
								$bill_amount = SubcontractorBills::find()->where(['payee_name' => $payee_name])->one()->bill_amount;

								$payment_date = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->payment_date;
								$tot_payment_amount = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->tot_payment_amount;

								if(strtotime($bill_date) <= strtotime($date_to))
								{
									echo "<tr>";
									echo "<td>".$serial_no."</td>";
									echo "<td>".$po_reference."</td>";
									echo "<td>".$creditor_ref."</td>";
									echo "<td>".$bill_date."</td>";
									echo "<td>".number_format((float)$bill_amount, 2, '.', ',')."</td>";
									$payment_details = AccPaymentDetail::find()->where(['pmt_main_id' => $pmt_id])->all();

									$total_amount = 0;

									if(!empty($payment_details)){
										foreach ($payment_details as $payment_detail) {
											$amount = $payment_detail->line_total;
											if($total_amount == 0){
												echo "<td>".number_format((float)$amount, 2, '.', ',')."</td>";
												echo "<td>".round((strtotime($date_to) - strtotime($payment_date))/ (60 * 60 * 24))."</td>";
												echo "</tr>";
												$serial_no += 1;
											}
											else{
												echo "<tr>";
												echo "<td>".$serial_no."</td>";
												echo "<td></td><td></td><td></td><td></td>";
												echo "<td>".number_format((float)$amount, 2, '.', ',')."</td>";
												echo "<td>".round((strtotime($date_to) - strtotime($payment_date))/ (60 * 60 * 24))."</td>";
												echo "</tr>";
												$serial_no += 1;
											}
											$total_amount += $amount;

											
										}

										echo "<tr>";
										echo "<td></td><td></td><td></td><td></td><td></td>";
										echo "<td><strong>".number_format((float)$total_amount, 2, '.', ',')."</strong></td><td></td>";
										echo "</tr>";
										echo "<tr><td><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
									}								
								}	
							}
							else
							{
								echo '<script>
								alert("No data found!");
								window.location.replace("index.php?r=accpaymentmain/creditor-details-summary");
								</script>';
								exit;								
							}							
						}
						?>
						
					</tbody>
				</table>

			 <?php } ?>

		
     	</div>
    </div>

</div>
