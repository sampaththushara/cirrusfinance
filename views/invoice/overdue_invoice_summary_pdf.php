<?php

use yii\helpers\Html;
use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\PaymentApplication;
use app\models\CompanyMaster;
use app\models\MaClient;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

$arry_data = json_decode($_GET['arry_data']);

$date_to = $arry_data[0];


?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Invoice CSS -->
	  	<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web'); ?>/css/bootstrap.min.css">
	  	<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web'); ?>/css/skin/invoice.css">

	  	<!-- Favicon -->
  		<link rel="shortcut icon" href="css/img/favicon.ico">

	</head>

	<body>

		<div class="overdue-invoice-summary invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>

			<h2 class="panel-title">Overdue Invoice Summary</h2>
			
		    <h3>As at : <?= $date_to; ?></h3>

			<table class="table">
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

							foreach ($invoice_datails as $invoice_datail) {
								if($i == 0){
									$payment_application_id = $invoice_datail->payment_application_id;
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
								$i += 1;
							}
							
						}

						$serial_no += 1;
						
					}
					?>
						
				</tbody>
			</table>
		</div>

	</body>

</html>