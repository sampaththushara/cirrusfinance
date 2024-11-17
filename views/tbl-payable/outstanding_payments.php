<?php
use yii\helpers\Html;
use app\models\TblPayable;
use app\models\AccBusiness;
use app\models\PayeeMaster;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Outstanding Payments';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "payable";

?>

<div class="outstanding-payments">
	<div class="admin-form theme-primary mw1000 center-block">

	    <div class="panel-body bg-light">
	        <div class="section-divider mt20 mb40">
	          <span> <?= $this->title; ?> </span>
	        </div>

			<p>
                <a class="btn btn-primary btn-float-right btn-print" href='index.php?r=/tbl-payable/outstanding-payments-pdf' target='_blank' title="Print Outstanding Payments"><i class="fa fa-print" aria-hidden="true"></i></a>
            </p>

	        <table class="table table-striped">

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

	</div>

</div>