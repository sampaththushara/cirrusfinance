<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\CaGroup;
use app\models\CompanyMaster;
use kartik\date\DatePicker;
use kartik\widgets\ActiveField as WidgetsActiveField;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Profit & Loss';
$this->params['breadcrumbs'][] = ['label' => 'Acc Bank Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

if(isset($count) && $count!='')
{
	$count = $count;
}
else
{
	$count = '3';
}

if(isset($entered_date) && $entered_date!='')
{
	$value = $entered_date;
}
else
{
	$entered_date = date("Y-03-31");
	$value = date("Y-03-31");
}

$company_name = CompanyMaster::find()->where(['id' => 1])->one()->company_legal_name;

?>

<style type="text/css">
	.trial-balance-create h1{
	    margin-bottom: 20px;
	    font-size: 25px;
		text-align: center;
	    text-transform: uppercase;
	}

	td {
		padding: 3px !important;
	}
	th {
		padding-left: 3px !important;
	}
</style>

<div class="trial-balance-create">

    <div class="admin-form theme-primary mw1000 center-block">
    	<h1><?= $company_name; ?></h1>

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            
    		
	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group">
					<div class="col-sm-1" style="padding-top: 10px;">As at</div>
				    <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'profit_loss_year', 
							'value' => $value,
							'options' => ['placeholder' => 'Select Date ...'],
							'pluginOptions' => [
								'format' => 'yyyy-mm-dd',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>
					<div class="col-sm-1" style="padding-top: 10px;">Years</div>
				    <div class="col-sm-4">
						<input type="number" name="count" class="form-control" value="<?php echo $count;?>" style="max-width: 25%; text-align: center;">
	    			</div>

	    			<div class="col-sm-2">
				        <?= Html::submitButton('Process', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>
    
				</div>
			<?php ActiveForm::end(); ?>

			<p>
				<?php $url_encode = 'index.php?r=/accreceiptmain/profit-loss-pdf&entered_date='.$entered_date.'&count='.$count; ?>

				<a class="btn btn-primary btn-float-right btn-print" href='<?= $url_encode; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
			</p>

			<table class="table">
				<thead>
					<tr>
						<?php
						$start = new DateTime($entered_date);
						echo "<th>For the Year Ended ".$start->format('jS F').",<br/> &nbsp; </th>";
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
					->where(['statement_type_id' => 2, 'parent_id' => NULL])
					->all();

					foreach ($parents as $parent) 
					{
						$parent_name = $parent->parent_name;
						echo "<tr><th>".strtoupper($parent_name)."</th><td></td><td></td></tr>";

						$subQuery = CaGroup::find()
						->select(['parent_id'])
						->where(['ca_level' => 3, 'statement_type_id' => 2])
						->andwhere(['like', 'parent_name', $parent_name . '%', false]);

						$level_2 = CaGroup::find()
						->where(['ca_level' => 2, 'statement_type_id' => 2, 'parent_name' => $parent_name])
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
							->where(['parent_id' => $level_2_id , 'statement_type_id' => 2, 'ca_level' => 3])
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
										echo "<td class='text-align-right'>".(number_format((float)$$CreateVar1, 0, '.', ',') ==0 ? '-' : ($parent->id ==5 ? '('.number_format((float)$$CreateVar1, 0, '.', ',').')' : number_format((float)$$CreateVar1, 0, '.', ',')))."</td>";
										$x1++;
									}
									echo "</tr>";
								}	
							}							
						}
						echo "<tr style='border-top: 2px ridge #000; border-bottom: 2px ridge #000;'><th>TOTAL ".strtoupper($parent_name)."</th>";

						$x1 = '1';
						$count2 = $count;
						for($count2; $count2 > 0; $count2--)
						{
							$CreateVar2 = 'SumYear'.$x1;
							if($parent->id ==4)
							{
								$CreateVar3 = 'IncomeSumYear'.$x1;
								$$CreateVar3 = $$CreateVar2;
							}

							if($parent->id ==5)
							{
								$CreateVar4 = 'ExpenseSumYear'.$x1;
								$$CreateVar4 = $$CreateVar2;							
							}							
							echo "<td class='text-align-right' style='font-weight: bold;'>".(number_format((float)$$CreateVar2, 0, '.', ',') ==0 ? '-' : ($parent->id ==5 ? '('.number_format((float)$$CreateVar2, 0, '.', ',').')' : number_format((float)$$CreateVar2, 0, '.', ',')))."</td>";
							$x1++;
						}
						echo "</tr>";						
					}
					echo "<tr style='border-bottom: 5px double #000'><th>Profit/Loss before Income Tax</th>";
					$x1 = '1';
					$count2 = $count;
					for($count2; $count2 > 0; $count2--)
					{
						$CreateVar3 = 'IncomeSumYear'.$x1;
						$CreateVar4 = 'ExpenseSumYear'.$x1;						
						echo "<td class='text-align-right' style='font-weight: bold;'>".(number_format((float)($$CreateVar3-$$CreateVar4), 0, '.', ',') ==0 ? '-' : (($$CreateVar3-$$CreateVar4) < 0 ? '('.number_format((float)($$CreateVar4-$$CreateVar3), 0, '.', ',').')' : number_format((float)($$CreateVar3-$$CreateVar4), 0, '.', ',')))."</td>";
						$x1++;
					}
					echo "</tr><tr><th> </th></tr><tr><td>Figures in brackets indicate deductions.</td></tr>";	

				?>

				</tbody>
			</table>
     	</div>
    </div>

</div>
