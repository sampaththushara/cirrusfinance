<?php
use yii\helpers\Html;
use app\models\TblReceivable;
use app\models\AccBusiness;
use app\models\PayerMaster;
use app\models\ReceivableCategory;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Outstanding Receivable';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "receivable";

?>

<div class="outstanding-receivables">
	<div class="admin-form theme-primary mw1000 center-block">

	    <div class="panel-body bg-light">
	        <div class="section-divider mt20 mb40">
	          <span> <?= $this->title; ?> </span>
	        </div>

			<p>
                <a class="btn btn-primary btn-float-right btn-print" href='index.php?r=/tbl-receivable/outstanding-receivables-pdf' target='_blank' title="Print Outstanding Payments"><i class="fa fa-print" aria-hidden="true"></i></a>
            </p>

	        <table class="table table-striped">

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

	</div>
</div>