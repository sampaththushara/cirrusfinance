<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\CaGroup;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'General Ledger';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";
?>

<div class="general-ledger">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            


	    	<?php $form = ActiveForm::begin(array('id'=>'my-form')); ?>

				<div class="form-group row">
					<?php

				        echo '<div class="col-sm-2"><label class="control-label">Account code :</label></div>';
						echo '<div class="col-sm-7">';
						echo Select2::widget([
						    'name' => 'code',
						    'data' => ArrayHelper::map(CaGroup::find()->where(['ca_level' => 3])->orderBy('code')->all(),'id','code'),
						    'options' => [
						        'placeholder' => 'Select Code ...',
						        'multiple' => true,
						        'selected' => true,
						    ],
	                        'pluginOptions' => [
	                            'allowClear' => true,
	                        ],
						]);
						echo '</div>';
				    ?>    
				</div>

	    		<div class="form-group row">
				    <label class="control-label col-sm-2" for="date">Period:</label>
				    <div class="col-sm-3">
	      				<?php
	      				$year = date('Y');
	      				$start_date = '01-04-'.date('Y');
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

			if(!empty($codes)){ ?>

				<hr>

				<div class="row">

	    			<div class="col-sm-offset-10 col-sm-2">

						<p>
							<?php 
							$arry_data = array();
							array_push($arry_data, $date_from);
							array_push($arry_data, $date_to);
							array_push($arry_data, $codes);
							$arry_data = json_encode($arry_data);

							$url = 'index.php?r=/cagroup/general-ledger-pdf&arry_data='.$arry_data;
			                ?>

			                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
			            </p>

			        </div>

			    </div>

			    <h3>General Ledger Listing</h3>

				<?php

				foreach ($codes as $id) {

					$code = CaGroup::find()->where(['id' => $id])->one()->code;
					$item_name = CaGroup::find()->where(['id' => $id])->one()->item_name;

					// if(!empty($code)){

						$entry_details = AccEntryDetail::find()->where(['char_of_acc_id' => $id])->all();

						if(!empty($entry_details)){

							$serial_no = 1;
							$dr = 0;
							$cr = 0;
							?>
							<div class="panel">
								<div class="panel-body bg-light">

									<?php
										if(!empty($code)){
											$acc_code = "(".$code.")";
										}
										else{
											$acc_code = "";
										}
									echo "<h4 class='text-align-center'>Account Code : ".$item_name." ".$acc_code."</h4>";
									echo "<h5 class='text-align-center'>Period : ".$date_from." to ".$date_to."</h5><br>";
									?>

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
													echo "<td>".$entry_date."</td>";
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
											else if($dr == $cr){
												$balace = 0;
												$balace_mark = "";
											}
											?>

											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td><strong>Balance</strong></td>
												<td class='text-align-right'><strong><?= number_format((float)$balace, 2, '.', ','); ?></strong></td>
												<td class='text-align-right'><strong><?= $balace_mark; ?></strong></td>
											</tr>

										</tbody>
									</table>

								</div>

							</div>

							<?php		
						}				

					// }

				}
			}

			?>


				
		
     	</div>
    </div>

</div>
