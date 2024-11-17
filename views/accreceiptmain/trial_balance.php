<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\CaGroup;
use app\models\CompanyMaster;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Trial Balance';
$this->params['breadcrumbs'][] = ['label' => 'Acc Bank Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

if(isset($entered_date)){
	$value = $entered_date;
}
else{
	$value = '';
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
				    <label class="control-label col-sm-2" for="date">As at:</label>
				    <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
							'name' => 'trial_balance_date', 
							'value' => $value,
							'options' => ['placeholder' => 'Select date ...'],
							'pluginOptions' => [
								'format' => 'yyyy-mm-dd',
								'todayHighlight' => true,
                				'todayBtn' => true,
                				'autoclose' => true
							]
						]);
	      				?>
	    			</div>

	    			<div class="col-sm-2">
				        <?= Html::submitButton('Process', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>
    
				</div>
			<?php ActiveForm::end(); ?>

			<?php
			if(!empty($entered_date)){ ?>

				<p>
					<?php $url_encode = 'index.php?r=/accreceiptmain/trial-balance-pdf&entered_date='.$entered_date; ?>

	                <a class="btn btn-primary btn-float-right btn-print" href='<?= $url_encode; ?>' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
	            </p>


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
							echo "<tr><td><br></td><td></td><td></td></tr>";

						}

					  ?>

					    <tr>
					    	<td></td>
					    	<td style="text-align:right">
					    	<hr><strong><?php echo number_format((float)$total_amount_dr, 2, '.', ','); ?></strong></td>
					    	<td style='text-align:right'>
					    	<hr><strong><?php echo number_format((float)$total_amount_cr, 2, '.', ','); ?></strong></td>
					    </tr>

					</tbody>
				</table>

			<?php } ?>

		
     	</div>
    </div>

</div>
