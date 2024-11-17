<?php

use yii\helpers\Html;
use app\models\CaGroup;
use app\models\CompanyMaster;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
$company_logo = CompanyMaster::find()->where(['id' => 1])->one()->image;

?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Invoice CSS -->
	  	<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web'); ?>/css/bootstrap.min.css">
	  	<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web'); ?>/css/skin/invoice.css">
	  	<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web'); ?>/css/style.css">

	  	<!-- Favicon -->
  		<link rel="shortcut icon" href="css/img/favicon.ico">

	</head>

	<body>

		<div class="invoice-coa-list invoice">

			<img class="company-logo" src="<?= Yii::getAlias('@web'); ?>/img/<?= $company_logo; ?>" >

			<h3 style="text-align: left;"><?= $company_name; ?></h3>
			<br>

			<h2 class="panel-title text-align-center">Chart of Account List</h2>
			<br>

		    <?php

			$parents_1 = CaGroup::find()->where(['statement_type_id' => 1, 'parent_id' => NULL])->all();
			$parents_2 = CaGroup::find()->where(['statement_type_id' => 2, 'parent_id' => NULL])->all();

			?>
			
			<div class="view-list">

				<h3 class="panel-title text-align-center">Balance Sheet Items</h3><br>
				
				<?php

				foreach ($parents_1 as $parent) {

					$parent_name = $parent->parent_name;
					echo "<table class='table'><tr><th>".$parent_name."</th></tr></table>";
					$level_2 = CaGroup::find()->where(['ca_level' => 2, 'parent_name' => $parent_name])->all();

					foreach ($level_2 as $item_level_2) {

						$level_2_id = $item_level_2->id;
						$item_name_level_2 = $item_level_2->item_name;
						echo "<table class='table level-2'><tr><td>".$item_name_level_2."</td><td class='view-code text-align-right'>".$item_level_2->code."</td></tr></table>";

						$level_3 = CaGroup::find()->where(['parent_id' => $level_2_id , 'statement_type_id' => 1, 'ca_level' => 3])->all();

						foreach ($level_3 as $item_level_3) {

							echo "<table class='table level-3'><tr><td>".$item_level_3->item_name."</td><td class='view-code text-align-right'>".$item_level_3->code."</td></tr></table>";
							
						}

					}

				}

				?>

				<pagebreak>

				<h3 class="panel-title text-align-center">Profit & Loss Items</h3><br>

				<?php

				foreach ($parents_2 as $parent) {

					$parent_name = $parent->parent_name;
					echo "<table class='table'><tr><th>".$parent_name."</th></tr></table>";
					$level_2 = CaGroup::find()->where(['ca_level' => 2, 'parent_name' => $parent_name])->all();

					foreach ($level_2 as $item_level_2) {
						
						$level_2_id = $item_level_2->id;
						$item_name_level_2 = $item_level_2->item_name;
						echo "<table class='table level-2'><tr><td>".$item_name_level_2."</td><td class='view-code text-align-right'>".$item_level_2->code."</td></tr></table>";

						$level_3 = CaGroup::find()->where(['parent_id' => $level_2_id , 'statement_type_id' => 2, 'ca_level' => 3])->all();

						foreach ($level_3 as $item_level_3) {

							echo "<table class='table level-3'><tr><td>".$item_level_3->item_name."</td><td class='view-code text-align-right'>".$item_level_3->code."</td></tr></table>";
							
						}

					}

				}

				?>
						
				
			</div>
		
		</div>

	</body>

</html>