<?php
use app\models\Journalmain;
use app\models\Journaldetail;
use app\models\CaGroup;
use app\models\CompanyMaster;

$journal = Journalmain::find()->where(['journal_id' => $id])->one();

$journal_details = Journaldetail::find()
	//->innerJoinWith('ca_group', 'acc_receipt_detail.chart_of_acc_id = ca_group.id')
	->where(['journal_main_id' => $id])
	->all();

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

$total_cr = 0;
$total_dr = 0;

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

			<h3 style="text-align: left;"><?= $company_name; ?></h3>

		</div>

		<h2 class="text-align-center">Journal Entry</h2>	

		<div class="row invoice">
			<div class="left-section col-md-6">
				<!-- <p>Sasanka</p> -->
			</div>
			<div class="right-section col-md-6">
				<p class="p-bold margin-bottm-none">Date</p>
				<p><?php echo date('m/d/Y'); ?></p>
				<p class="p-bold margin-bottm-none">Reference</p>
				<p><?= $journal->reference_no; ?></p>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>Reference No.</th>
					<th>Journal ID</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?= $journal->reference_no; ?></td>
					<td><?= $journal->journal_id; ?></td>
					<td><?= $journal->description; ?></td>

				</tr>
			</tbody>
		</table>

		<table class="table">
			<thead>
				<tr>
					<th>Item Name</th>
					<!-- <th class='text-align-center'>Qty</th>
					<th class='text-align-right'>Unit Price</th> -->
					<th>Code</th>
					<th class="text-align-right">Cr</th>
					<th class="text-align-right">Dr</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($journal_details as $key => $value) {
					echo "<tr>";
					$item_name = CaGroup::find()->where(['id' => $value->chart_of_acc_id])->one()->item_name;
					$coa_code = CaGroup::find()->where(['id' => $value->chart_of_acc_id])->one()->code;
					$dr_or_cr = Journaldetail::find()->where(['chart_of_acc_id' => $value->chart_of_acc_id, 'journal_main_id' => $id])->one()->dr_or_cr;
					$line_total = Journaldetail::find()->where(['chart_of_acc_id' => $value->chart_of_acc_id, 'journal_main_id' => $id])->one()->line_total;
					echo "<td>".$item_name."</td>";
					echo "<td>".$coa_code."</td>";
					// echo "<td class='text-align-center'>".$value->quantity."</td>";
					// echo "<td class='text-align-right'>".number_format((float)$value->unit_price, 2, '.', ',')."</td>";
					if($dr_or_cr == "C"){
						echo "<td class='text-align-right'>".number_format((float)$line_total, 2, '.', ',')."</td>";
						echo "<td class='text-align-right'></td>";
						$total_cr += $line_total;

					}
					else if($dr_or_cr == "D"){
						echo "<td class='text-align-right'></td>";
						echo "<td class='text-align-right'>".number_format((float)$line_total, 2, '.', ',')."</td>";
						$total_dr += $line_total;
					}
					echo "</tr>";
				} ?>

				<tr>
					<?php 

					$tot_journal_amount = Journalmain::find()->where(['journal_id' => $id])->one()->tot_journal_amount;
					echo "<td></td><td></td>
						<td class='p-bold text-align-right'>".number_format((float)$total_cr, 2, '.', ',')."</td>
						<td class='text-align-right p-bold'>".number_format((float)$total_dr, 2, '.', ',')."</td>";

					?>
				</tr>
			</tbody>
		</table>

	</body>
</html>