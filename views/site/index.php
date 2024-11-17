<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'MyAccounts';

//$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['index']];
$this->params['selectedBtn'] = "home";
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-index  admin-form theme-primary mw1000 center-block">

    <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=cagroup/dashboard" id="box1">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Chart of Accounts</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=journalmain" id="box5">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/journal_entry.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/journal_entry_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Journal Entry</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div> 
        <div class="col-sm-2">
            <a href="index.php?r=invoice/create-invoice" id="box4">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/create_invoice.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/create_invoice_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Create Invoice</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>  
        <div class="col-sm-2">
            <a href="index.php?r=tbl-receivable" id="box6">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/receivables.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/receivables_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Receivables</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>                     
        <div class="col-sm-2">
            <a href="index.php?r=accreceiptmain" id="box2">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/record_a_receipt.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/record_a_receipt_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Record a Receipt</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=tbl-payable" id="box7">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/payables.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/payables_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Payables</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>        
    </div>

    <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=accpaymentmain" id="box3">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/make_a_payment.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/make_a_payment_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Make a Payment</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=site/reports" id="box8">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/reports.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/reports_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Reports</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=site/admin_main" id="box9">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/admin_panel.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/admin_panel_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Admin Panel</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
    </div>

</div>