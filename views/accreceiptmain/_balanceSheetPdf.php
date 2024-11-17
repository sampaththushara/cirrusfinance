<?php
use app\models\AccEntryDetail;
use app\models\CaGroup;
use app\models\CompanyMaster;

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;
?>

<!DOCTYPE html>
<html>
<head>

<!-- Invoice CSS -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/skin/invoice.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="css/img/favicon.ico">

  <style type="text/css">

  </style>
</head>

	<body>
	<div class="trial-balance-create invoice">
	<h3 style="text-align: center;"><?= $company_name; ?></h3>
	<h3 style="text-align: center;">Balance Sheet</h3>    		

	<?php
	if(isset($entered_date)){ ?>

		<table class="table">
				<thead>
					<tr>
						<?php
						$start = new DateTime($entered_date);
						echo "<th>As at ".$start->format('jS F').",<br/> &nbsp; </th>";
						$year = explode('-', $entered_date)[0];
						$MonthDate = explode('-', $entered_date)[1]."-".explode('-', $entered_date)[2];
						$count1 = $count;

						for($count1; $count1 > 0; $count1--)
						{
							$x = $count1-1;
							echo "<th style='text-align:right'>" . ($year-$x) . "<br/>Rs.000</th>";
						}		
						?>
					</tr>
				</thead>
				<tbody>

				<?php	
					function getEntryAmountSum($code, $year, $MonthDate)
					{
						$entryamountsum = Yii::$app->db->createCommand("SELECT 
																		IFNULL(SUM(entry_amount),0) 
																		FROM acc_entry_detail 
																		INNER JOIN acc_entry_main ON acc_entry_detail.entry_id = acc_entry_main.entry_id
																		WHERE char_of_acc_id = ".$code." AND (acc_entry_main.entry_date BETWEEN '".($year-1)."-".$MonthDate."' AND '".$year."-".$MonthDate."')")
																		->queryScalar();	
						return $entryamountsum;																				
					}
					
					$parents = CaGroup::find()
					->where(['statement_type_id' => 1, 'parent_id' => NULL])
					->all();

					foreach ($parents as $parent) 
					{
						$parent_name = $parent->parent_name;
						echo "<tr><th>".strtoupper($parent_name)."</th><td></td><td></td></tr>";

						$subQuery = CaGroup::find()
						->select(['parent_id'])
						->where(['ca_level' => 3, 'statement_type_id' => 1])
						->andwhere(['like', 'parent_name', $parent_name . '%', false]);

						$level_2 = CaGroup::find()
						->where(['ca_level' => 2, 'statement_type_id' => 1, 'parent_name' => $parent_name])
						->andwhere(['in', 'id', $subQuery])
						->all();

						$count2 = $count;
						$x1 = '1';
						for($count2; $count2 > 0; $count2--)
						{
							$CreateVar2 = 'SumYear'.$x1;
							$$CreateVar2 = 0;
							$x1++;
						}	
						
						foreach ($level_2 as $item_level_2) 
						{
							$level_2_id = $item_level_2->id;
							$item_name_level_2 = $item_level_2->item_name;

							$coa_item = CaGroup::find()
							->where(['parent_id' => $level_2_id , 'statement_type_id' => 1, 'ca_level' => 3])
							->all();

							//statement_type_id = 1 , is Balance sheet items.
							//$coa_item = CaGroup::find()->andFilterWhere(['like', 'parent_name', $parent_name])->all();

							echo "<tr><th>".$item_name_level_2."</th><td></td><td></td></tr>";					

							foreach ($coa_item as $item)
							{
								$count2 = $count;
								$code = $item->id;

								$coa_list = AccEntryDetail::find()->where(['char_of_acc_id' => $code])->all();

								if(!empty($coa_list))
								{
									echo "<tr><td>".$item->item_name."</td>";	
									$x1 = '1';
									for($count2; $count2 > 0; $count2--)
									{
										$x = $count2-1;
										$CreateVar1 = 'AmountYear'.$x1;
										$$CreateVar1 = getEntryAmountSum($code, ($year-$x), $MonthDate);
										
										$CreateVar2 = 'SumYear'.$x1;
										$$CreateVar2 += $$CreateVar1;
										echo "<td class='text-align-right'>".(number_format((float)$$CreateVar1, 0, '.', ',') ==0 ? '-' : number_format((float)$$CreateVar1, 0, '.', ','))."</td>";
										$x1++;
									}
									echo "</tr>";
								}	
							}							

							if($parent->id ==2)
							{
								$nameid2 = $parent->parent_name;
								$x1 = '1';
								$count2 = $count;
								for($count2; $count2 > 0; $count2--)
								{
									$CreateVar2 = 'SumYear'.$x1;
									$CreateVar3 = 'Lyear'.$x1;
									$$CreateVar3 = $$CreateVar2;
									$x1++;
								}
							}
	
							if($parent->id ==3)
							{
								$nameid3 = $parent->parent_name;
								$x1 = '1';
								$count2 = $count;
								for($count2; $count2 > 0; $count2--)
								{
									$CreateVar2 = 'SumYear'.$x1;
									$CreateVar3 = 'ERyear'.$x1;
									$$CreateVar3 = $$CreateVar2;
									$x1++;
								}															
							}
						}
						echo "<tr style='border-top: 2px ridge #000; ".($parent->id !=2 && $parent->id !=3 ? 'border-bottom: 5px double #000' : 'border-bottom: 2px ridge #000')."'><th>TOTAL ".strtoupper($parent_name)."</th>";

						$x1 = '1';
						$count2 = $count;
						for($count2; $count2 > 0; $count2--)
						{
							$CreateVar2 = 'SumYear'.$x1;
							echo "<td class='text-align-right' style='font-weight: bold;'>".(number_format((float)$$CreateVar2, 0, '.', ',') ==0 ? '-' : number_format((float)$$CreateVar2, 0, '.', ','))."</td>";
							$x1++;
						}
						echo "</tr>";
					}
					echo "<tr style='border-bottom: 5px double #000'><th>TOTAL ".strtoupper($nameid2)." & ".strtoupper($nameid3)."</th>";
					$x1 = '1';
					$count2 = $count;
					for($count2; $count2 > 0; $count2--)
					{
						$CreateVar2 = 'Lyear'.$x1;
						$CreateVar3 = 'ERyear'.$x1;
						echo "<td class='text-align-right' style='font-weight: bold;'>".(number_format((float)$$CreateVar2 + $$CreateVar3, 0, '.', ',') ==0 ? '-' : number_format((float)$$CreateVar2 + $$CreateVar3, 0, '.', ','))."</td>";
						$x1++;
					}
					echo "</tr>";

				?>

				</tbody>
			</table>

	<?php } ?>
	</div>
	</body>

</html>
