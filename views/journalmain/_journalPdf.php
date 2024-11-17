<?php

use yii\helpers\Html;
use app\models\CaGroup;
use app\models\Journalmain;
use app\models\Journaldetail; 
use app\models\CompanyMaster;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

$arry_data = json_decode($_GET['arry_data']);

$date_from = $arry_data[0];
$date_to = $arry_data[1];


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

		<div class="journal invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>

			<h2 class="panel-title">Journal</h2>
			<h3 class="panel-title">From <?= $date_from; ?> To: <?= $date_to; ?></h3>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Description</th>
						<th>Account</th>
						<th class="text-align-right">Dr</th>
						<th class="text-align-right">Cr</th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$journal_entries = Journalmain::find()->all();
					$total_dr = 0;
					$total_cr = 0;

					foreach ($journal_entries as $journal) {
						$journal_date = $journal->journal_date;
					
						if((strtotime($date_from) <= strtotime($journal_date)) && (strtotime($journal_date) <= strtotime($date_to))){

								$journal_id = $journal->journal_id;
								$description = $journal->description;

								$journal_details = Journaldetail::find()->where(['journal_main_id' => $journal_id])->all();
								$journal_details_c = Journaldetail::find()->where(['journal_main_id' => $journal_id, 'dr_or_cr' => 'C'])->all();
								$cnt = 0;

								foreach ($journal_details as $journal_detail) {
									$dr_or_cr = $journal_detail->dr_or_cr;
									$line_total = $journal_detail->line_total;
									$chart_of_acc_id = $journal_detail->chart_of_acc_id;
									$code = CaGroup::find()->where(['id' => $chart_of_acc_id])->one()->code;
									$item_name = CaGroup::find()->where(['id' => $chart_of_acc_id])->one()->item_name;

									echo "<tr>";
									if($cnt == 0){
										echo "<td>".$journal_id."</td>";
										echo "<td>".$description."</td>";
									}
									else{
										echo "<td> </td>";
										echo "<td> </td>";
									}

									if($dr_or_cr == "D"){
										echo "<td>".$code." - ".$item_name."</td>";
										echo "<td class='text-align-right'>".number_format((float)$line_total, 2, '.', ',')."</td>";
										echo "<td></td>";
										echo "</tr>";
										$cnt +=1;
										$total_dr += $line_total;
									}

									else if($dr_or_cr == "C"){
										echo "<td>".$code." - ".$item_name."</td>";
										echo "<td></td>";
										echo "<td class='text-align-right'>".number_format((float)$line_total, 2, '.', ',')."</td>";
										echo "</tr>";
										$cnt +=1;
										$total_cr += $line_total;
									}

									
								}

						}

					}

					?>
					<tr>
					<td></td><td></td><td></td>
					<td class="p-bold text-align-right"><?= number_format((float)$total_dr, 2, '.', ','); ?></td>
					<td class="p-bold text-align-right"><?= number_format((float)$total_cr, 2, '.', ','); ?></td>
					</tr>

				</tbody>
			</table>
		   
		</div>

	</body>

</html>