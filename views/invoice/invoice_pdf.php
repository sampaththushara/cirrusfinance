<?php

use yii\helpers\Html;
use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\PaymentApplication;
use app\models\Tax;
use app\models\CompanyMaster;
use app\models\MaClient;
use app\models\AccReceiptMain;
use app\models\AccReceiptDetail;
use app\models\CaGroup;
use app\models\AccBusiness;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;
$company_reg_no = CompanyMaster::find()->where(['id' => 1])->one()->company_reg_no;

$invoice_date = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->invoice_date;
$invoice_date = date("Y-m-d", strtotime($invoice_date));
$vat = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->VAT;
$nbt = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->NBT;
$business_id = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->business_id;
$bill_id = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->bill_id;

// $invoice_number = str_pad( $invoice_id, 4, 0, STR_PAD_LEFT );
// $year = date('Y');
// $invoice_number = $year.$invoice_number;

$payment_applications = InvoiceDetail::find()->where(['invoice_id' => $invoice_id])->all();

// client name
$invoice_details = InvoiceDetail::find()->where(['invoice_id' => $invoice_id])->orderBy(['payment_application_id'=> SORT_DESC])->one();
$payment_application_id = $invoice_details->payment_application_id;
$client_code = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->Client_Code;
$client_name = MaClient::find()->where(['Client_Code' => $client_code])->one()->Client_Name;

// client address
$client_address = MaClient::find()->where(['Client_Name' => $client_name])->one()->Client_Address;

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

		<div class="payment-applications-invoice invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>

			<h2 class="panel-title">VAT Invoice</h2>

			<p class="text-align-right">
				Reg. No: <?= $company_reg_no; ?>
			</p>

			<p class="text-align-right">
				Invoice: #<?= $invoice_id; ?>
			</p>

			<p class="text-align-right">
				Date: <?= $invoice_date; ?>
			</p>

		    <p>Payer (Client) : <?= $client_name; ?></p>

		    <p>Address : <?= $client_address; ?></p>

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Project</th>
						<th>Particulars</th>
						<th class='text-align-right'>Amount</th>
					</tr>
				</thead>
				<tbody>

					<?php

					$serial_no = 1;
					$total = 0;

					foreach ($payment_applications as $payment_application) {

						$payment_application_id = $payment_application->payment_application_id;
						$particulars = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->particulars;
						$amount = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->amount;
						$payment_application_business_id = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->business_id;
						if(!empty($payment_application_business_id)){
							$business_name = AccBusiness::find()->where(['business_id' => $payment_application_business_id])->one()->business_name;
						}
						else{
							$business_name = "";
						}
						$total += $amount; 

						echo "<tr>";
						echo "<td>".$serial_no."</td>";
						echo "<td>".$business_name."</td>";
						echo "<td>".$particulars."</td>";
						echo "<td class='text-align-right'>".number_format((float)$amount, 2, '.', ',')."</td>";
						echo "</tr>";

						$serial_no += 1;

					}

					$vat_amount = $total * $vat / 100;
					$nbt_amount = ($total + $vat_amount) * $nbt / 100;
					$net_total_amount = ($total + $vat_amount) + (($total + $vat_amount) * $nbt / 100);

					echo "<tr>";
					echo "<td><br></td><td></td><td></td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td> VAT ".$vat."% </td>";
					echo "<td class='text-align-right'>".number_format((float)$vat_amount, 2, '.', ',')."</td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>  NBT ".$nbt."%  </td>";
					echo "<td class='text-align-right'>".number_format((float)$nbt_amount, 2, '.', ',')."</td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td class='p-bold'> Total Amount </td>";
					echo "<td class='text-align-right p-bold'>".number_format((float)$net_total_amount, 2, '.', ',')."</td>";
					echo "</tr>";
						
					?>
					
				</tbody>
			</table>


			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Project</th>
						<th class="text-align-right">Retention</th>
					</tr>
				</thead>
				<tbody>

					<?php

					$retention_amount_total = 0;
					$serial_no = 1;
					
					foreach ($payment_applications as $payment_application) {

						$payment_application_id = $payment_application->payment_application_id;
						$retention_amount = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->retention_amount;
						$retention_business_id = PaymentApplication::find()->where(['id' => $payment_application_id])->one()->business_id;
						if(!empty($retention_business_id)){
							$retention_business_name = AccBusiness::find()->where(['business_id' => $retention_business_id])->one()->business_name;
						}
						else{
							$retention_business_name = "";
						}
						$retention_amount_total += $retention_amount;

						echo "<tr>";
						echo "<td>".$serial_no."</td>";
						echo "<td>".$retention_business_name."</td>";
						echo "<td class='text-align-right'>".number_format((float)$retention_amount, 2, '.', ',')."</td>";
						echo "</tr>";
						$serial_no += 1;

					}

					echo "<tr>";
					echo "<td></td>";
					echo "<td class='p-bold'>Total</td>";
					echo "<td class='text-align-right p-bold'>".number_format((float)$retention_amount_total, 2, '.', ',')."</td>";
					echo "</tr>";
						
					?>
					
				</tbody>
			</table>

			<?php

			$receipts = AccReceiptMain::find()->where(['invoice_id' => $invoice_id])->all();

			if(!empty($receipts)){

				$serial_no = 1;
				$amount_tot = 0;

				?>

				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Previously Received Payments</th>
							<th>Description</th>
							<th class='text-align-right'>Amount</th>
						</tr>
					</thead>
					<tbody>

						<?php
						foreach ($receipts as $receipt) 
						{
							$rpt_id = $receipt->rpt_id;
							$receipt_details = AccReceiptDetail::find()->where(['rpt_main_id' => $rpt_id])->all();

							foreach ($receipt_details as $receipt_detail) 
							{
								$coa_id = $receipt_detail->chart_of_acc_id;
								$description = $receipt_detail->rpt_detail_desc;
								$amount = $receipt_detail->line_total;
								$item_name = Cagroup::find()->where(['id' => $coa_id])->one()->item_name;

								echo "<tr>";
								echo "<td>".$serial_no."</td>";
								echo "<td>".$item_name."</td>";
								echo "<td>".$description."</td>";
								echo "<td class='text-align-right'>".number_format((float)$amount, 2, '.', ',')."</td>";
								echo "</tr>";
								$amount_tot += $amount;
								$serial_no += 1;
							}

						}

						echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td>Total Amount</td>";
						echo "<td class='text-align-right'>".number_format((float)$amount_tot, 2, '.', ',')."</td>";
						echo "</tr>";

						?>

					</tbody>
				</table>

			<?php 

			}

			?>

		</div>

	</body>

</html>