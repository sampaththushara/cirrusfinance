<?php
use app\models\AccReceiptMain;
use app\models\AccReceiptDetail;
use app\models\CaGroup;
use app\models\CompanyMaster;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

$payer_details = AccReceiptMain::find()->where(['rpt_id' => $id])->one();

$receipt_details = AccReceiptDetail::find()
	//->innerJoinWith('ca_group', 'acc_receipt_detail.chart_of_acc_id = ca_group.id')
	->where(['rpt_main_id' => $id])
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

		<div class="invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

	    	<h1 class="text-align-left" style="text-align: left;"><?= $company_name; ?></h1>

			<h2 class="text-align-center">Receipt</h2>	

			<div class="left-section col-md-6">
				<!-- <p>Sasanka</p> -->
			</div>

			<div class="right-section col-md-6">
				<p class="p-bold margin-bottm-none">Date</p>
				<p><?php echo date('m/d/Y'); ?></p>
				<p class="p-bold margin-bottm-none">Reference</p>
				<p><?= $payer_details->reference_no; ?></p>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>Reference No.</th>
					<th>Receipt ID</th>
					<th>Payer Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $payer_details->reference_no; ?></td>
					<td><?= $payer_details->rpt_id; ?></td>
					<td><?= $payer_details->payer_name; ?></td>
					<td><?= $payer_details->description; ?></td>

				</tr>
			</tbody>
		</table>

		<table class="table">
			<thead>
				<tr>
					<th>Item Name</th>
					<th>Description</th>
					<!-- <th class='text-align-center'>Qty</th>
					<th class='text-align-right'>Unit Price</th> -->
					<th class="text-align-right">Line Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($receipt_details as $key => $value) {
					echo "<tr>";
					$item_name = CaGroup::find()->where(['id' => $value->chart_of_acc_id])->one()->item_name;
					$receipt_detail_des = $value->rpt_detail_desc;
					echo "<td>".$item_name."</td>";
					echo "<td>".$receipt_detail_des."</td>";
					// echo "<td class='text-align-center'>".$value->quantity."</td>";
					// echo "<td class='text-align-right'>".number_format((float)$value->unit_price, 2, '.', ',')."</td>";
					echo "<td class='text-align-right'>".number_format((float)$value->line_total, 2, '.', ',')."</td>";
					echo "</tr>";
				} ?>

				<tr>
					<?php 

					$tot_receipt_amount = AccReceiptMain::find()->where(['rpt_id' => $id])->one()->tot_receipt_amount;
					echo "<td></td>
						<td class='border-none p-bold text-align-right'>Total Receipt Amount</td>
						<td class='text-align-right p-bold'>".number_format((float)$tot_receipt_amount, 2, '.', ',')."</td>";

					?>
				</tr>
			</tbody>
		</table>

	</body>
</html>