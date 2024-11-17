<?php

use yii\helpers\Html;
use app\models\AccPaymentMain;
use app\models\AccPaymentDetail;
use app\models\SubcontractorBills;

$arry_data = json_decode($_GET['arry_data']);

$date_to = $arry_data[0];
$creditors_ref = $arry_data[1];

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

		<div class="payable-to-creditors invoice">

			<h2 class="panel-title">Creditor Details Summary</h2>

		    <h3>As at : <?= $date_to; ?></h3>

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

						foreach ($creditors_ref as $creditor_ref) {
							$payee_name = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->payee_name;
							$pmt_id = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->pmt_id;
							$po_reference = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->po_reference;
							$bill_date = SubcontractorBills::find()->where(['payee_name' => $payee_name])->one()->bill_date;
							$bill_amount = SubcontractorBills::find()->where(['payee_name' => $payee_name])->one()->bill_amount;

							$payment_date = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->payment_date;
							$tot_payment_amount = AccPaymentMain::find()->where(['reference_no' => $creditor_ref])->one()->tot_payment_amount;

							if(strtotime($bill_date) <= strtotime($date_to)){
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
									echo "<td class='p-bold'>".number_format((float)$total_amount, 2, '.', ',')."</td><td></td>";
									echo "</tr>";
									echo "<tr><td><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
								}

								
							}
							
						}
						?>
						
					</tbody>
				</table>
		</div>

	</body>

</html>