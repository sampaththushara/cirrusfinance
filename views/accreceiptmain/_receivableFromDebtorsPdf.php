<?php

use yii\helpers\Html;
use app\models\AccReceiptMain;
use app\models\AccReceiptDetail;
use app\models\Invoice;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\View;

$arry_data = json_decode($_GET['arry_data']);

$date_from = $arry_data[0];
$date_to = $arry_data[1];
$debtors_ref = $arry_data[2];


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

			<h2 class="panel-title">Receivable from Debtors</h2>

		    <h3>From: <?= $date_from; ?> To: <?= $date_to; ?></h3>

			<table class="table">
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

						if(!empty($invoice_id)){

							if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

								$outstanding_date = round((strtotime($date_to) - strtotime($receipt_date))/ (60 * 60 * 24));
								$ary_date[$debtor_ref] = $outstanding_date;
							}
						}
					}

					arsort($ary_date);

					foreach ($ary_date as $key => $value) {
						$debtor_ref = $key;
						$payer_name = AccReceiptMain::find()->where(['reference_no' => $debtor_ref])->one()->payer_name;
						$receipt_date = AccReceiptMain::find()->where(['payer_name' => $payer_name])->one()->receipt_date;
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
						
							if((strtotime($date_from) <= strtotime($receipt_date)) && (strtotime($receipt_date) <= strtotime($date_to))){

								$outstanding_date = round((strtotime($date_to) - strtotime($receipt_date))/ (60 * 60 * 24));
								echo "<tr>";
									echo "<td>".$serial_no."</td>";
									echo "<td>".$invoice."</td>";
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
							$serial_no += 1;
						}
						
						
					}
					?>
					<tr>
						<td><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
						<td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
						<td class="p-bold">Balance</td>
						<td class="p-bold"><?php if($balance_1 > 0){ echo number_format((float)$balance_1, 2, '.', ','); }  ?></td>
						<td class="p-bold"><?php if($balance_2 > 0){ echo number_format((float)$balance_2, 2, '.', ','); }  ?></td>
						<td class="p-bold"><?php if($balance_3 > 0){ echo number_format((float)$balance_3, 2, '.', ','); }  ?></td>
						<td class="p-bold"><?php if($balance_4 > 0){ echo number_format((float)$balance_4, 2, '.', ','); }  ?></td>
					</tr>
					
				</tbody>
			</table>
		</div>

	</body>

</html>