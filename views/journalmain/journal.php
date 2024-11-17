<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\CaGroup;
use app\models\Journalmain;
use app\models\Journaldetail;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Journal';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";
?>

<div class="journal">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            


	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

	    		<div class="form-group row">
				    <label class="control-label col-sm-2" for="date">From:</label>
				    <div class="col-sm-3">
	      				<?php
	      				$year = date('Y');
	      				if(Yii::$app->request->post()){
	      					$start_date = $date_from;
	      				}
	      				else{
	      					$start_date = '01-04-'.date('Y');
	      				}
	      				
	      				echo DatePicker::widget([
							'name' => 'date_from', 
							'value' => $start_date,
							'options' => ['placeholder' => 'From', 'id' => 'date-from'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>

				    <label class="control-label text-align-center col-sm-1" for="date"> to</label>

				    <div class="col-sm-3">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'date_to', 
							'value' => date('d-m-Y'),
							'options' => ['placeholder' => 'To', 'id' => 'date-to'],
							'pluginOptions' => [
								'format' => 'dd-mm-yyyy',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>
    
				</div>

				<div class="form-group row">

	    			<div class="col-sm-2">
				        <?= Html::submitButton('Submit', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>

				</div>

			<?php ActiveForm::end(); ?>

			<?php

			if(Yii::$app->request->post()){ ?>

				<hr>

				<div class="row">

	    			<div class="col-sm-offset-10 col-sm-2">

						<p>
							<?php 
							$arry_data = array();
							array_push($arry_data, $date_from);
							array_push($arry_data, $date_to);
							$arry_data = json_encode($arry_data);

							$url = 'index.php?r=/journalmain/journal-pdf&arry_data='.$arry_data;
			                ?>

			                 <a class="btn btn-primary btn-float-right btn-print" href='<?= $url; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
			            </p>

			        </div>

			    </div>

			    <h3 class="text-align-center">Journal</h3>

			    <p class="text-align-center"><strong>From <?= $date_from; ?> To: <?= $date_to; ?></strong></p>
			    <br>
			    <br>

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
						<td class="text-align-right"><strong><?= number_format((float)$total_dr, 2, '.', ','); ?></strong></td>
						<td class="text-align-right"><strong><?= number_format((float)$total_cr, 2, '.', ','); ?></strong></td>
						</tr>

					</tbody>
				</table>
							
				<?php } ?>
				
		
     	</div>
    </div>

</div>
