<?php

use yii\helpers\Html;
use app\models\AccPaymentMain;
use app\models\AccPaymentDetail;

$arry_data = json_decode($_GET['arry_data']);

$entered_payment_date = $arry_data[0];
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

			<h2 class="panel-title">Payable to Creditors</h2>

		    <h3>Payment Date: <?= $entered_payment_date; ?></h3>

			<table class="table">
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
		</div>

	</body>

</html>