<?php
use app\models\AccPaymentMain;
use app\models\AccPaymentDetail;
use app\models\CaGroup;

$payee_details = AccPaymentMain::find()->where(['pmt_id' => $id])->one();

$payment_details = AccPaymentDetail::find()
	//->innerJoinWith('ca_group', 'acc_receipt_detail.chart_of_acc_id = ca_group.id')
	->where(['pmt_main_id' => $id])
	->all();

?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Invoice CSS -->
	  	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	  	<link rel="stylesheet" type="text/css" href="css/skin/invoice.css">

	  	<!-- Favicon -->
  		<link rel="shortcut icon" href="css/img/favicon.ico">

	</head>

	<body>

		<h2>Payment</h2>	

		<div class="row invoice">
			<div class="left-section col-md-6">
				<!-- <p>Sasanka</p> -->
			</div>
			<div class="right-section col-md-6">
				<p class="p-bold margin-bottm-none">Date</p>
				<p><?php echo date('m/d/Y'); ?></p>
				<p class="p-bold margin-bottm-none">Reference</p>
				<p><?= $payee_details->reference_no; ?></p>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>Reference No.</th>
					<th>Payment ID</th>
					<th>Payee Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $payee_details->reference_no; ?></td>
					<td><?= $payee_details->pmt_id; ?></td>
					<td><?= $payee_details->payee_name; ?></td>
					<td><?= $payee_details->description; ?></td>

				</tr>
			</tbody>
		</table>

		<table class="table">
			<thead>
				<tr>
					<th>Item Name</th>
					<!-- <th class='text-align-center'>Qty</th>
					<th class='text-align-right'>Unit Price</th> -->
					<th class="text-align-right">Line Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($payment_details as $key => $value) {
					echo "<tr>";
					$item_name = CaGroup::find()->where(['id' => $value->chart_of_acc_id])->one()->item_name;
					echo "<td>".$item_name."</td>";
					// echo "<td class='text-align-center'>".$value->quantity."</td>";
					// echo "<td class='text-align-right'>".number_format((float)$value->unit_price, 2, '.', ',')."</td>";
					echo "<td class='text-align-right'>".number_format((float)$value->line_total, 2, '.', ',')."</td>";
					echo "</tr>";
				} ?>

				<tr>
					<?php 

					$tot_payment_amount = AccPaymentMain::find()->where(['pmt_id' => $id])->one()->tot_payment_amount;
					echo "
						<td class='border-none p-bold text-align-right'>Total Payment Amount</td>
						<td class='text-align-right p-bold'>".number_format((float)$tot_payment_amount, 2, '.', ',')."</td>";

					?>
				</tr>
			</tbody>
		</table>

	</body>
</html>