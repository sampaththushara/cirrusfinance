<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CaGroup */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";

?>

<div class="site-reports mw1000 center-block">

    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading large">
                    <p class="panel-title">General Reports</p>
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading large">
                    <p class="panel-title">Final Accounts</p>
                </div>
            </div>
        </div>
    </div>

    <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain/receivable-from-debtors">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/receivable_from_debtors.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/receivable_from_debtors_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Receivable from Debtors</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accpaymentmain/payable-to-creditors">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/payable_to_creditors.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/payable_to_creditors_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Payable to Creditors</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain/bank-reconcilation">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/bank_recolcile.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/bank_recolcile_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Bank Reconcile</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=cagroup/general-ledger">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/general_ledger.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/general_ledger_color.png'; ?>" alt="img">
                <div class="box">
                    <p>General Ledger</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=journalmain/journal">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/journal.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/journal_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Journal</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain/trial-balance">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/trial_balance.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/trial_balance_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Trial Balance</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
    </div>


    <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=cagroup/coa-list">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts_list.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts_list_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Chart of Accounts List</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=invoice/overdue-invoice-summary">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/overdue_invoice_summary.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/overdue_invoice_summary_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Overdue Invoice Summary</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accpaymentmain/creditor-details-summary">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/creditor_details_summary.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/creditor_details_summary_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Creditor Details Summary</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain/balance-sheet">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/trial_balance.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/trial_balance_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Balance Sheet</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>	
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain/profit-loss">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/reports.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/reports_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Profit & Loss</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>	        		
    </div>
              

</div>

<!-- <div class="row table-layout table-clear-xs reports-page">

  <div class="col-xs-6 col-sm-4 br-a br-light bg-light pv20 ph30 va-t">

    <h4 class="micro-header">General Reports</h4>
    <div class="row" id="content-type">      

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=accreceiptmain/receivable-from-debtors">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Receivable from Debtors
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=accpaymentmain/payable-to-creditors">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Payable to Creditors
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=accreceiptmain/bank-reconcilation">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Bank Reconcil
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=cagroup/general-ledger">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> General Ledger
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=journalmain/journal">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Journal
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=cagroup/coa-list">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Chart of Account List
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=invoice/overdue-invoice-summary">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Overdue Invoice Summary
        </a>
      </div>

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=accpaymentmain/creditor-details-summary">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Creditor Details Summary
        </a>
      </div>

    </div>
  </div>
  
  
  <div class="col-xs-6 col-sm-4 br-a br-light bg-light pv20 ph30 va-t">

    <h4 class="micro-header">Final Accounts</h4>
    <div class="row" id="content-type">

      <div class="col-sm-6 col-xs-12 report-box">
        <a class="holder-style p15 mb20 holder-active" href="index.php?r=accreceiptmain/trial-balance">
          <span class="fa fa-newspaper-o holder-icon"></span>
          <br> Trial Balance
        </a>
      </div>      

    </div>
  </div>

  
</div> -->


<!-- ////////////////////////////////////////////////////// -->


<!-- <?php
/* @var $this yii\web\View */
?>

<style>
.card-content {
    text-align: center!important;
}
</style>

<?php
$user_level = Yii::$app->getUser()->identity->user_level;
?>        
        <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <a href="index.php?r=tstudentinfo/student_list">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">STUDENT DETAILS <br>REPORT</p>
                                    <h3 class="title"> 
                                        <small></small>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> Exam Year wise Report
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <a href="index.php?r=tstudentinfo/eligibility_report">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">SCHOOL LEVEL - Student <br>Wise</p>
                                    <h3 class="title"> 
                                        <small></small>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> Month wise Report
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <a href="index.php?r=tstudentinfo/bursary_school_rpt">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">School Level - Grade <br>wise</p>
                                    <h3 class="title"> 
                                        <small></small>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> Month wise Report
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <?php 
                        if($user_level=='superadmin' || $user_level=='admin' || $user_level=='zone' || $user_level=='province' || $user_level=='ministry'){ ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="index.php?r=tstudentinfo/bursary_zonal_rpt">
                                <div class="card card-stats">                                
                                    <div class="card-content">
                                        <p class="category">ZONAL LEVEL - School <br>wise</p>
                                        <h3 class="title"> 
                                            <small></small>
                                        </h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Month Range wise Report
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>

                        <?php 
                        if($user_level=='superadmin' || $user_level=='admin' || $user_level=='province' || $user_level=='ministry'){ ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="index.php?r=tstudentinfo/bursary_provincial_rpt">
                                <div class="card card-stats">                                
                                    <div class="card-content">
                                        <p class="category">PROVINCIAL LEVEL - Zone <br>wise</p>
                                        <h3 class="title"> 
                                            <small></small>
                                        </h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Month Range wise Report
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>

                        <?php 
                        if($user_level=='superadmin' || $user_level=='admin' || $user_level=='ministry'){ ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="index.php?r=tstudentinfo/bursary_ministry_rpt">
                                <div class="card card-stats">                                
                                    <div class="card-content">
                                        <p class="category">MINISTRY LEVEL - Province <br>wise</p>
                                        <h3 class="title"> 
                                            <small></small>
                                        </h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Month Range wise Report
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>  
                        <?php } ?>  

                        <?php 
                        if($user_level=='superadmin' || $user_level=='admin' || $user_level=='zone' || $user_level=='province'){ ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="index.php?r=tstudentinfo/payment_slip">
                                <div class="card card-stats">                                
                                    <div class="card-content">
                                        <p class="category">Payment SLIP<br>file</p>
                                        <h3 class="title"> 
                                            <small></small>
                                        </h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Zonal file - Month wise
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>               

                </div>
            </div>




<?php
$script = <<< JS
    demo.initDashboardPageCharts();
JS;
$this->registerJs($script);
?> -->