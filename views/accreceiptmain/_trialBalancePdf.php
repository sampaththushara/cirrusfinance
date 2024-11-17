<?php
use yii\helpers\Html;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\CaGroup;
use app\models\CompanyMaster;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

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

		<div class="trial-balance-create invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>
	        
	        <h2 class="panel-title">Trial Balance <i>(As at : <?= $entered_date; ?>)</i> </h2>
	    		

			<?php
			if(isset($entered_date)){ ?>

				<table class="table">
					<thead>
						<tr>
							<th><!-- Account Code <br> (COA) --></th>
							<!-- <th>Description</th> -->
							<th style='text-align:right'>Debit</th>
							<th style='text-align:right'>Credit</th>
						</tr>
					</thead>
					<tbody>

						<?php

					    $start_date = Date('Y-04-01');

						$total_amount_dr = 0;
						$total_amount_cr = 0;
						$net_amount_cr = 0;
						$net_amount_dr = 0;
					    $parents = CaGroup::find()->where(['parent_id' => NULL])->all();

						foreach ($parents as $parent) {

							$parent_name = $parent->parent_name;
							echo "<tr><th>".$parent_name."</th><td></td><td></td></tr>";

							$coa_item = CaGroup::find()->andFilterWhere(['like', 'parent_name', $parent_name])->all();

							foreach ($coa_item as $item) {

								$amount_cr = 0;
								$amount_dr = 0;
								$code = $item->id;

								$coa_list = AccEntryDetail::find()->where(['char_of_acc_id' => $code])->all();

								if(!empty($coa_list)){

									$accentrydetails = AccEntryDetail::find()->where(['char_of_acc_id' => $code])->all();

									foreach ($accentrydetails as $accentrydetail) {

										$entry_id = $accentrydetail->entry_id;
										$entry_date = AccEntryMain::find()->where(['entry_id' => $entry_id])->one()->entry_date;
					    				$dr_cr = $accentrydetail->dr_cr;

										if((strtotime($start_date) <= strtotime($entry_date)) && (strtotime($entry_date) <= strtotime($entered_date))){
											if($dr_cr == "D"){
												$amount_dr += $accentrydetail->entry_amount;
											}
											else if($dr_cr == "C"){
												$amount_cr += $accentrydetail->entry_amount;
											}
										}

									}

									if($amount_dr > $amount_cr){
										$net_amount_dr = $amount_dr - $amount_cr;
										$total_amount_dr += $net_amount_dr;
										$dr_or_cr = "D";
									}

									else if($amount_dr < $amount_cr){
										$net_amount_cr = $amount_cr - $amount_dr;
										$total_amount_cr += $net_amount_cr;
										$dr_or_cr = "C";
									}

									else if($amount_dr == $amount_cr){
										$net_amount = 0;
										$dr_or_cr = "";
									}
									else{
										$dr_or_cr = "null";
									}

									$item_name = $item->item_name;
									echo "<tr><td>".$item_name."</td>";

									if($dr_or_cr == "D"){
										echo "<td class='text-align-right'>".number_format((float)$net_amount_dr, 2, '.', ',')."</td>";
										echo "<td class='text-align-right'>0.00</td></tr>";
									}
									else if($dr_or_cr == "C"){
										echo "<td class='text-align-right'>0.00</td>";
										echo "<td class='text-align-right'>".number_format((float)$net_amount_cr, 2, '.', ',')."</td></tr>";
									}
									else{
										echo "<td class='text-align-right'>0.00</td>";
										echo "<td class='text-align-right'>0.00</td></tr>";
									}

								}
								

							}
							echo "<tr><td></td><td></td><td></td></tr>";

						}


					  ?>

					    <tr>
					    	<td></td>
					    	<td style='text-align:right'>
					    	<hr><strong><?php echo number_format((float)$total_amount_dr, 2, '.', ','); ?></strong></td>
					    	<td style='text-align:right'>
					    	<hr><strong><?php echo number_format((float)$total_amount_cr, 2, '.', ','); ?></strong></td>
					    </tr>

					</tbody>
				</table>

			<?php } ?>

		</div>
	</body>

</html>
