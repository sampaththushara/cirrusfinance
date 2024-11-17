<?php

use yii\helpers\Html;
use app\models\AccReceiptMain;
use app\models\AccReceiptDetail;
use app\models\Invoice;
use app\models\Tax;

$arry_invoice = json_decode($_GET['arry_invoice']);

$date_from = $arry_invoice[0];
$date_to = $arry_invoice[1];
$debtor_ref = $arry_invoice[2];

$serial_no = 1;

$payer_name = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->payer_name;
$receipt_date = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->receipt_date;
$tot_receipt_amount = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->tot_receipt_amount;
$invoice_id = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->invoice_id;
$invoice_date = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->invoice_date;
$invoice_amount = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->tot_invoice_amount;
$VAT = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->VAT;
$NBT = Invoice::find()->where(['invoice_id' => $invoice_id])->one()->NBT;
$invoice_number = str_pad( $invoice_id, 4, 0, STR_PAD_LEFT );
$year = date('Y');
$invoice = $invoice_number;
$balance = $invoice_amount - $tot_receipt_amount;


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

		<div class="receivable-from-debtors invoice">

			<h1>Company Name</h1>

			<h2 class="panel-title">VAT Invoice</h2>

			<p class="text-align-right">
				Invoice: #<?= $invoice; ?>
			</p>

			<p class="text-align-right">
				Date: <?= date('d-m-Y'); ?>
			</p>

		    <p>Payer (Client) : <?php echo AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->payer_name; ?></p>

		    <p>Address : </p>

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Invoice</th>
						<th>Date of Invoice</th>
						<th>Amount Invoiced</th>
						<th>Amount Receivable</th>
						<th>Date Received</th>
						<th>Balance</th>
						<th>Project Ref.</th>
						<th>No. of Days Outstanding</th>
					</tr>
				</thead>
				<tbody>

					<?php
					
					if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

						echo "<tr>";
						echo "<td>".$serial_no."</td>";
						echo "<td>".$invoice."</td>";
						echo "<td>".$invoice_date."</td>";
						echo "<td>".number_format((float)$invoice_amount, 2, '.', ',')."</td>";
						echo "<td>".number_format((float)$tot_receipt_amount, 2, '.', ',')."</td>";
						echo "<td>".$receipt_date."</td>";
						echo "<td>".number_format((float)$balance, 2, '.', ',')."</td>";
						echo "<td>".$debtor_ref."</td>"; 
						echo "<td>".round((strtotime($date_to) - strtotime($receipt_date))/ (60 * 60 * 24))."</td>";
						echo "</tr>";

					}
					$serial_no += 1;
						
					?>
					
				</tbody>
			</table>


			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Particulars</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody>

					<?php
					
					if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

						echo "<tr><td><br></td><td></td><td></td></tr>";

						echo "<tr>";
						echo "<td></td>";
						echo "<td>VAT ".$VAT."%</td>";
						echo "<td></td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td></td>";
						echo "<td>NBT ".$NBT."%</td>";
						echo "<td></td>";
						echo "</tr>";


						echo "<tr>";
						echo "<td></td>";
						echo "<td class='text-align-right'>Total</td>";
						echo "<td></td>";
						echo "</tr>";

					}
					$serial_no += 1;
						
					?>
					
				</tbody>
			</table>

		</div>

	</body>

</html>