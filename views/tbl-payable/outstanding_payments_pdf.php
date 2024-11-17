<?php

use yii\helpers\Html;
use app\models\TblPayable;
use app\models\AccBusiness;
use app\models\PayeeMaster;
use app\models\CompanyMaster;
use yii\web\View;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;
$company_reg_no = CompanyMaster::find()->where(['id' => 1])->one()->company_reg_no;

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

		<div class="outstanding-payments invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>

			<h2 class="panel-title">Outstanding Payments</h2>

			<table class="table">
				<thead>
					<tr>
						<th></th><th></th><th></th><th></th><th></th>
						<th colspan="4">Days Outstanding</th>
					</tr>
					<tr>
	        			<th>#</th>
	        			<th>Payee Name</th>
	        			<th>Project</th>
	        			<th>PO Ref.</th>
	        			<th>Due Date</th>
	        			<th>1-30 Days</th>
						<th>31-60 Days</th>
						<th>61-90 Days</th>
						<th>> 90 Days</th>
					</tr>
				</thead>

	        	<tbody>
	        		<?php
	        		$payables = TblPayable::find()->where(['payable_status' => 'Not Paid'])->all();
	        		$serial_no = 1;

	        		foreach ($payables as $payable) {
	        			$payable_id = $payable->payable_id;
	        			$project_id = $payable->project_id;
	        			$due_date = $payable->due_date;
	        			$payee_id = $payable->payee_id;
	        			$description = $payable->description;
	        			$period_from = $payable->period_from;
	        			$period_to = $payable->period_to;
	        			$project_name = AccBusiness::find()->where(['business_id' => $project_id])->one()->business_name;
	        			$payee_name = PayeeMaster::find()->where(['payee_id' => $payee_id])->one()->payee_name;
	        			$date = Date('Y-m-d');
	        			$days_outstanding = round((strtotime($date) - strtotime($due_date))/ (60 * 60 * 24));

	        			?>

	        			<tr>
	        				<td><?= $serial_no; ?></td>
	        				<td><?= $payee_name; ?></td>
	        				<td><?= $project_name; ?></td>
	        				<td></td>
	        				<td><?= $due_date; ?></td>
        					<?php if($days_outstanding > 0){ 
        						if(($days_outstanding > 0) && ($days_outstanding <= 30)){ 
								 	echo "<td>".$days_outstanding."</td>";
								} 
								else{ echo "<td></td>"; } 

								if(($days_outstanding > 30) && ($days_outstanding <= 60)){ 
								 	echo "<td>".$days_outstanding."</td>";
								} 
								else{ echo "<td></td>"; } 

								if(($days_outstanding > 60) && ($days_outstanding <= 90)){ 
								 	echo "<td>".$days_outstanding."</td>";
								} 
								else{ echo "<td></td>"; } 

								if($days_outstanding > 90){ 
								 	echo "<td>".$days_outstanding."</td>";
								} 
								else{ echo "<td></td>"; } 

		        				$serial_no += 1; 
		        			}

	        				else{ echo "<td></td><td></td><td></td><td></td>"; } 
	        				?>
	        			</tr>

	        			<?php
	        		}
	        		?>
	        	</tbody>
	        	
			</table>
		</div>

	</body>

</html>