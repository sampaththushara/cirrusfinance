<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccReceiptMain;
use app\models\AccReceiptDetail;
use app\models\CaGroup;
use app\models\Invoice;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Receivable from Debtors';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

?>

<div class="receivable-from-debtors">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            


	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group row">
				    <label class="control-label col-sm-2" for="date">Date Range:</label>
				    <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'date_from', 
							//'value' => $value,
							'options' => ['placeholder' => 'From', 'id' => 'date-from'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>

				    <div class="col-sm-4">
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
	    			</div>
    
				</div>

				<div class="form-group row">
					<?php

				        echo '<div class="col-sm-2"><label class="control-label">Debtors :</label></div>';
						echo '<div class="col-sm-8">';
						echo Select2::widget([
						    'name' => 'debtors_ref',
						    'data' => ArrayHelper::map(AccReceiptMain::find()->all(),'reference_no','payer_name'),
						    'options' => [
						        'placeholder' => 'Select Debtors ...',
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


			<!-- ----- Results of receivable from debtors ----- -->


			<?php if(!empty($debtors_ref)){ ?>

				<p>
					<?php 
					$arry_data = array();
					array_push($arry_data, $date_from);
					array_push($arry_data, $date_to);
					array_push($arry_data, $debtors_ref);
					$arry_data = json_encode($arry_data);

					$url = 'index.php?r=/accreceiptmain/receivable-from-debtors-pdf&arry_data='.$arry_data;
	                ?>
	                
	                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
	            </p>
				</div>


				<table class="table table-striped table-dark">
					<thead>
						<tr>
							<th>#</th>
							<th>Invoice</th>
							<th>Date of Invoice</th>
							<th>Name</th>
							<th>Project Ref.</th>
							<th>Amount Invoiced</th>
							<th>Amount Received</th>
							<th>Date Received</th>
							<th>No. of Days Outstanding</th>
							<th>More than 90 Days</th>
							<th>61-90 Days</th>
							<th>31-60 Days</th>
							<th>1-30 Days</th>
						</tr>
					</thead>
					<tbody>

						<?php

						$serial_no = 1;

						$ary_date = array();

						foreach ($debtors_ref as $debtor_ref) {

							$receipt_date = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->receipt_date;
							$invoice_id = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->invoice_id;

							if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

								$outstanding_date = round((strtotime($date_to) - strtotime($receipt_date))/ (60 * 60 * 24));
								$ary_date[$debtor_ref] = $outstanding_date;
							}
						}

						arsort($ary_date);

						foreach ($ary_date as $key => $value) {
							$debtor_ref = $key;
							
							$payer_name = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->payer_name;
							$receipt_date = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->receipt_date;
							$tot_receipt_amount = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->tot_receipt_amount;
							$invoice_id = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->invoice_id;
							$balance_1 = 0;
							$balance_2 = 0;
							$balance_3 = 0;
							$balance_4 = 0;

							if(!empty($invoice_id)){
								$invoice_date = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->invoice_date;
								$invoice_amount = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->tot_invoice_amount;
								$invoice_number = str_pad( $invoice_id, 4, 0, STR_PAD_LEFT );
								$year = date('Y');
								$invoice = $invoice_number;
								$balance = $invoice_amount - $tot_receipt_amount;

								$arry_invoice = array();
								array_push($arry_invoice, $date_from);
								array_push($arry_invoice, $date_to);
								array_push($arry_invoice, $debtor_ref);
								$arry_invoice = json_encode($arry_invoice);

								$url = 'index.php?r=/accreceiptmain/invoice&arry_invoice='.$arry_invoice;

								if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

									$outstanding_date = round((strtotime($date_to) - strtotime($receipt_date))/ (60 * 60 * 24));

									echo "<tr>";
									echo "<td>".$serial_no."</td>";
									echo "<td><a href='".$url."' target='_blank'>".$invoice."</a></td>";
									echo "<td>".$invoice_date."</td>";
									echo "<td>".$payer_name."</td>";
									echo "<td>".$debtor_ref."</td>"; 
									echo "<td>".number_format((float)$invoice_amount, 2, '.', ',')."</td>";
									echo "<td>".number_format((float)$tot_receipt_amount, 2, '.', ',')."</td>";
									echo "<td>".$receipt_date."</td>";
									echo "<td>".$outstanding_date."</td>";
									if(90 < $outstanding_date){
										echo "<td>".number_format((float)$balance, 2, '.', ',')."</td>";
										echo "<td> </td>";
										echo "<td> </td>";
										echo "<td> </td>";
										$balance_1 += $balance;
									}
									else if((61 <= $outstanding_date) && ($outstanding_date < 90)){
										echo "<td> </td>";
										echo "<td>".number_format((float)$balance, 2, '.', ',')."</td>";
										echo "<td> </td>";
										echo "<td> </td>";
										$balance_2 += $balance;
									}
									else if((31 <= $outstanding_date) && ($outstanding_date <= 60)){
										echo "<td> </td>";
										echo "<td> </td>";
										echo "<td>".number_format((float)$balance, 2, '.', ',')."</td>";
										echo "<td> </td>";
										$balance_3 += $balance;
									}
									else if((1 <= $outstanding_date) && ($outstanding_date <= 30)){
										echo "<td> </td>";
										echo "<td> </td>";
										echo "<td> </td>";
										echo "<td>".number_format((float)$balance, 2, '.', ',')."</td>";
										$balance_4 += $balance;
									}
									
									echo "</tr>";

								}
							}

							$serial_no += 1;
							
						}
						?>
						<tr>
							<td><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td class="p-bold">Balance</td>
							<td class="p-bold"><?php if(isset($balance_1) && $balance_1 > 0){ echo number_format((float)$balance_1, 2, '.', ','); }  ?></td>
							<td class="p-bold"><?php if(isset($balance_1) && $balance_2 > 0){ echo number_format((float)$balance_2, 2, '.', ','); }  ?></td>
							<td class="p-bold"><?php if(isset($balance_1) && $balance_3 > 0){ echo number_format((float)$balance_3, 2, '.', ','); }  ?></td>
							<td class="p-bold"><?php if(isset($balance_1) && $balance_4 > 0){ echo number_format((float)$balance_4, 2, '.', ','); }  ?></td>
						</tr>
					</tbody>
				</table>

			 <?php } ?>

		
     	</div>
    </div>

</div>
