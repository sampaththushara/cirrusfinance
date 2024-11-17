<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\PaymentApplication;
use app\models\MaClient;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = 'Overdue Invoice Summary';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

?>

<div class="overdue-invoice-summary">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title">Squire Mech Engineering (Private) Limited</span>
            </div>
            
            <h3 class="panel-title text-align-center p-bold"><?= Html::encode($this->title) ?></h3>
            <br>
            <br>


	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group row">

	    			<div class="col-sm-offset-3 col-sm-1">
				    	<label class="vertical-align-middle">As at : </label>
	    			</div>

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

	    			<div class="col-sm-2">
				        <?= Html::submitButton('Submit', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>

    
				</div>

			<?php ActiveForm::end(); ?>


			<!-- ----- Results of overdue invoice summary ----- -->

			<?php if(Yii::$app->request->post()){ ?>

				<hr>

				<p>
					<?php 
					$arry_data = array($date_to);
					$arry_data = json_encode($arry_data);

					$url = 'index.php?r=/invoice/overdue-invoice-summary-pdf&arry_data='.$arry_data;
	                ?>

	                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
	            </p>


				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Invoice</th>
							<th>Date of Invoice</th>
							<th>Client</th>
							<th>Amount Outstanding</th>
							<th>No. of Days Outstanding</th>
						</tr>
					</thead>
					<tbody>

						<?php

						$serial_no = 1;

						$invoices = Invoice::find()->all();

						foreach ($invoices as $invoice) {

							$invoice_date = $invoice->invoice_date;

							if(strtotime($invoice_date) <= strtotime($date_to)){

								$invoice_id = $invoice->invoice_id;
								$invoice_datails = InvoiceDetail::find()->where(['invoice_id' => $invoice_id])->all();

								$i = 0;
								$client = "";

								$amount_outstanding = $invoice->tot_invoice_amount;
								$days_outstanding = round((strtotime($date_to) - strtotime($invoice_date))/ (60 * 60 * 24));

								foreach ($invoice_datails as $invoice_datail) 
								{
									if($i == 0)
									{
										$payment_application_id = $invoice_datail->payment_application_id;
										if(PaymentApplication::find()->where(['id' => $payment_application_id])->one() !='')
										{
											$client_code = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->Client_Code;
											$client = MaClient::find()->where(['Client_Code' => $client_code])->one();
											$client_name = $client->Client_Name;

											echo "<tr>";
											echo "<td>".$serial_no."</td>";
											$invoice_url = 'index.php?r=invoice/invoice&invoice_id='.$invoice_id;
											echo "<td><a href='".$invoice_url."' target='_blank'>".$invoice_id."</a></td>";
											echo "<td>".$invoice_date."</td>";
											echo "<td>".$client_name."</td>";

											echo "<td>".number_format((float)$amount_outstanding, 2, '.', ',')."</td>";
											echo "<td>".$days_outstanding."</td>";
											echo "</tr>";
										}
										else
										{
											echo '<script>
											alert("Payment application record was not found!");
											window.location.replace("index.php?r=invoice/overdue-invoice-summary");
											</script>';
											exit;
										}
									}
									//$i += 1;
								}
								
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
