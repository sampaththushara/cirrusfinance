<?php

use yii\helpers\Html;
use app\models\TblReceivable;
use app\models\AccBusiness;
use app\models\PayerMaster;
use app\models\ReceivableCategory;
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

			<h2 class="panel-title">Outstanding Receivable</h2>

			<table class="table">
				<thead>
					<tr>
						<th></th><th></th><th></th><th></th><th></th>
						<th colspan="4">Days Outstanding</th>
					</tr>
					<tr>
	        			<th>#</th>
	        			<th>Payer Name</th>
	        			<th>Project</th>
	        			<th>Receivable Category</th>
	        			<th>Due Date</th>
	        			<th>1-30 Days</th>
						<th>31-60 Days</th>
						<th>61-90 Days</th>
						<th>> 90 Days</th>
					</tr>
				</thead>

	        	<tbody>
	        		<?php
	        		$receivables = TblReceivable::find()->where(['receivable_status' => 'Not Receipt'])->all();
	        		$serial_no = 1;

	        		foreach ($receivables as $receivable) {
	        			$receivable_id = $receivable->receivable_id;
	        			$project_id = $receivable->project_id;
	        			$due_date = $receivable->due_date;
	        			$payer_id = $receivable->payer_id;
	        			$description = $receivable->receivable_description;
	        			$period_from = $receivable->period_from;
	        			$period_to = $receivable->period_to;
	        			$project_name = AccBusiness::find()->where(['business_id' => $project_id])->one()->business_name;
	        			$payer_name = PayerMaster::find()->where(['payer_id' => $payer_id])->one()->payer_name;
	        			$date = Date('Y-m-d');
	        			$days_outstanding = round((strtotime($date) - strtotime($due_date))/ (60 * 60 * 24));
						$receivable_category_id = TblReceivable::find()->where(['receivable_id' => $receivable_id])->one()->receivable_category;
    					$receivable_category = ReceivableCategory::find()->where(['Receivable_Cat_ID' => $receivable_category_id])->one()->Receivable_Category;

	        			?>

	        			<tr>
	        				<td><?= $serial_no; ?></td>
	        				<td><?= $payer_name; ?></td>
	        				<td><?= $project_name; ?></td>
	        				<td><?= $receivable_category; ?></td>
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