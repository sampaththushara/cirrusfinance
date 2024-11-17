<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\AccEntryMain;
use app\models\AccEntryDetail;
use app\models\CaGroup;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use app\models\AccBankAccount;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Bank Reconcilation';
$this->params['breadcrumbs'][] = ['label' => 'Bank Reconcilation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

/*if(isset($entered_date)){
	$value = $entered_date;
}
else{
	$value = date('d-M-Y', strtotime('+0 days'));
}*/
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
    	<h1>Squire Mech Engineering (Private) Limited</h1>

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>
            
    		
	    	
	    	<!--?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?-->
	    	<?php $form = ActiveForm::begin(array('id'=>'my-form','class' => 'form-horizontal')); ?>
	    		<div class="form-group">
				    <label class="control-label col-sm-1" for="date">Date:</label>
				    <div class="col-sm-4">
	      				<?php
	      				echo DatePicker::widget([
	      					'id' => 'statement_date_id',
							'name' => 'statement_date', 
							'value' => $model->statement_date,
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

	    			<!--label class="control-label col-sm-2" for="date">Statement Balance:</label>
	    			<div class="col-sm-4">
	    				<?= $form->field($model, 'statement_amount')->textInput()->label(false) ?>
	    			</div-->

	    			<div class="col-sm-1">
				        <?= Html::submitButton('Process', ['class' => 'btn btn-rounded btn-primary']) ?>
				    </div>
    
				</div>
			

			<?php //echo $statement_amount;die;
			if(isset($statement_date)){ 
				if($statement_date !=''){
				?>

				

				<table class="table">
							<thead>
								<tr>
									<th style='text-align:left'>Code</th>
									<th style='text-align:left'>Name</th>
									<th style='text-align:right'>Deposits</th>
									<th style='text-align:right'>Withdrawals</th>
									<th style='text-align:right'>Balance</th>
									<th style='text-align:center'>Last Reconcilation</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$all_bank_accounts = AccBankAccount::find()->all();

							    foreach ($all_bank_accounts as $bank_acc) {
							    	$account_id = $bank_acc->account_id;
							    	$account_name = $bank_acc->account_name;
							    	$account_code = $bank_acc->account_code;
							    	$last_reconcil = $bank_acc->last_reconcil;
							    	if($last_reconcil ==''){
							    		$last_reconcil = '<b class="text-info"> Never </b>';
							    	}
							    	
							    	//--receipts--
							    	$deposits = 0;
							    	$query = (new \yii\db\Query())->from('acc_receipt_main')
								    ->Where(['reconciled'=> 0])
								    ->andWhere(['receipt_type'=> 'bank'])
								    ->andwhere(['and', "receipt_date<='$statement_date'"])
								    ->andwhere(['and', "account_id='$account_id'"]);
									$deposits = $query->sum('tot_receipt_amount');

									//--payments--
									$withdrowals=0;
							    	$query = (new \yii\db\Query())->from('acc_payment_main')
								    ->Where(['reconciled'=> 0])
								    ->andwhere(['and', "payment_date<='$statement_date'"])
								    ->andwhere(['and', "account_id='$account_id'"]);
									$withdrowals = $query->sum('tot_payment_amount');

									
									echo "<tr>";
									echo "<td>".$account_code."</td>";
									echo "<td>".$account_name."</td>";
									echo "<td style='text-align:right'>".number_format((float)$deposits, 2, '.', ',')."</td>";
									echo "<td style='text-align:right'>".number_format((float)$withdrowals, 2, '.', ',')."</td>";
									echo "<td style='text-align:right'>".number_format((float)$deposits-$withdrowals, 2, '.', ',')."</td>";
									echo "<td style='text-align:center'>".$last_reconcil."</td>";
									echo "<td><input class='mytext'type='text' id='".$account_id."'></td>";
									echo "<td><lable class='label label-md bg-primary button_rec' data-recid='".$account_id."'>Set</lable>
									</td>";
									echo "<td><lable id='".$account_id."loader'></lable></td>";
									echo "</tr>";
							    }
							    ?>
							</tbody>
							</table>

							

			<?php } } ?>

<?php ActiveForm::end(); ?>
		
     	</div>
    </div>

</div>



<?php

$script = <<< JS
$('.button_rec').on('click', function(e) {
	var record_id = $(this).data('recid');
   	var reconcil_amount = $('#'+record_id).val();
   	var statement_date = $('#statement_date_id').val();

    $('#'+record_id+'loader').html('<img src="../assets/img/loading.gif"> Verifying...');
    $.ajax({
       url: 'index.php?r=accreceiptmain/verify_bankrec_data',              
       type: "POST",
       //data : $(this).attr('data-recid'), 
       data : {account_id : record_id, reconcil_amount: reconcil_amount, statement_date: statement_date },     
       success: function(data) {
            $('#'+record_id+'loader').html('');
            $('#'+record_id+'loader').html(data);
       }
    });
});
JS;
$this->registerJs($script);

?> 

