<?php

use yii\helpers\Html;
use app\models\CaGroup;
use app\models\AccEntryMain;
use app\models\AccEntryDetail; 

$arry_data = json_decode($_GET['arry_data']);

$date_from = $arry_data[0];
$date_to = $arry_data[1];
$codes = $arry_data[2];

// var_dump($codes);
// die();

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

		<div class="general-ledger invoice">

			<h2 class="panel-title">General Ledger Listing</h2>

		    <?php

		    	$code_num = 0;
		    	$code_count = 0;

		    	// Count code numbers for pagebreak
		    	foreach ($codes as $id) {

					$code = CaGroup::find()->where(['id' => $id])->one()->code;
					
					if(!empty($code)){

						$entry_details = AccEntryDetail::find()->where(['char_of_acc_id' => $id])->all();

						if(!empty($entry_details)){
							$code_count += 1;
						}
					}
				}


				// Print codes
				foreach ($codes as $id) {

					$code = CaGroup::find()->where(['id' => $id])->one()->code;
					$item_name = CaGroup::find()->where(['id' => $id])->one()->item_name;

					// if(!empty($code)){

						$entry_details = AccEntryDetail::find()->where(['char_of_acc_id' => $id])->all();

						if(!empty($entry_details)){

							$serial_no = 1;
							$dr = 0;
							$cr = 0;
							$code_num += 1;
							?>
							<div class="panel">
								<div class="panel-body bg-light">

									<div class="text-align-center">

										<?php
										if(!empty($code)){
											$acc_code = "(".$code.")";
										}
										else{
											$acc_code = "";
										}
										echo "<h5>Account Name : ".$item_name." ".$acc_code."</h5>";
										echo "<h5>Period : ".$date_from." to ".$date_to."</h5><br>";
										?>

									</div>

									<table class="table table-striped">

										<thead>
											<tr>
												<th>#</th>
												<th>Date</th>
												<th>Description</th>
												<th>Contra</th>
												<th class='text-align-right'>Dr</th>
												<th class='text-align-right'>Cr</th>
											</tr>
										</thead>

										<tbody>

											<?php


											foreach ($entry_details as $entry_detail) {

												$entry_id = $entry_detail->entry_id;
												$amount = $entry_detail->entry_amount;
												$dr_cr = $entry_detail->dr_cr;
												$entry_date = AccEntryMain::find()->where(['entry_id' => $entry_id])->one()->entry_date;
												$narration = AccEntryMain::find()->where(['entry_id' => $entry_id])->one()->narration;

												if((strtotime($date_from) <= strtotime($entry_date)) && (strtotime($entry_date) <= strtotime($date_to))){
													
													echo "<tr>";
													echo "<td>".$serial_no."</td>";
													echo "<td>".date("d-m-Y", strtotime($entry_date))."</td>";
													echo "<td>".$narration."</td>";
													echo "<td></td>";
													if($dr_cr == 'D'){
														echo "<td class='text-align-right'>".number_format((float)$amount, 2, '.', ',')."</td><td></td>";
														$dr += $amount;
													}
													else if($dr_cr == 'C'){
														echo "<td></td><td class='text-align-right'>".number_format((float)$amount, 2, '.', ',')."</td>";
														$cr += $amount;
													}
													echo "</tr>";

													$serial_no += 1;
												}

											}
											?>

											<tr><td><br></td><td></td><td></td><td></td><td></td><td></td></tr>

											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td class='text-align-right'><strong><?= number_format((float)$dr, 2, '.', ','); ?></strong></td>
												<td class='text-align-right'><strong><?= number_format((float)$cr, 2, '.', ','); ?></strong></td>
											</tr>

											<?php
											if($dr > $cr){
												$balace = $dr - $cr;
												$balace_mark = "Dr";
											}
											else if($dr < $cr){
												$balace = $cr - $dr;
												$balace_mark = "Cr";
											}
											else if($dr = $cr){
												$balace = 0;
												$balace_mark = "";
											}
											?>

											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td class='text-align-right'><strong>Balance</strong></td>
												<td class='text-align-right'><strong><?= number_format((float)$balace, 2, '.', ','); ?></strong></td>
												<td class='text-align-center'><strong><?= $balace_mark; ?></strong></td>
											</tr>

										</tbody>
									</table>

								</div>

							</div>

							<?php if($code_num < $code_count){ ?>

								<pagebreak>

								<?php
							}
						}				

					// }

				}

			?>
		</div>

	</body>

</html>