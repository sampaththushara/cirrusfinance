<?php 

// echo Yii::$app->user->id;
// die;
use yii\helpers\Html;
$this->title = 'Admin Panel';
$this->params['breadcrumbs'][] =  $this->title;
$this->params['selectedBtn'] = "admin";

?>

<div class="site-admin-panel mw1000 center-block">
  
    <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=accbusiness">
                <img class="image"  src="<?php echo Yii::getAlias('@web').'/img/project.png'; ?>" alt="img">
                <img class="image hover"  src="<?php echo Yii::getAlias('@web').'/img/project_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Project</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accbusinessduration">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/business_period.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/business_period_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Business Period</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=accbankaccount">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/bank_accounts.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/bank_accounts_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Bank Accounts</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=acccashaccount">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/cash_accounts.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/cash_accounts_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Cash Accounts</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=cagroup">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts_admin.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/chart_of_accounts_admin_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">Chart of Accounts Admin</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=site/user_permission">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/user_permission_management.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/user_permission_management_color.png'; ?>" alt="img">
                <div class="box">
                    <p class="padding-bottom-none">User / Permission Management</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
    </div>

      <div class="box-section row">
        <div class="col-sm-2">
            <a href="index.php?r=companymaster">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/company_master.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/company_master_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Company Master</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=payee-master/admin-panel">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/payer_payee.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/payer_payee_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Payer / Payee</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=expense-master">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/expense_master.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/expense_master_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Expense Master</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
        <div class="col-sm-2">
            <a href="index.php?r=vehicles">
                <img class="image" src="<?php echo Yii::getAlias('@web').'/img/vehicle.png'; ?>" alt="img">
                <img class="image hover" src="<?php echo Yii::getAlias('@web').'/img/vehicle_color.png'; ?>" alt="img">
                <div class="box">
                    <p>Vehicle</p>
                    <div class="circle"></div>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- <div class="row table-layout table-clear-xs">

    <div class="col-xs-12 col-sm-4 br-a br-light bg-light pv20 ph30 va-t">

      <h4 class="micro-header">Admin Panel</h4>
      <div class="row" id="content-type">
 
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=accbusiness">
            <span class="fa fa-picture-o holder-icon"></span>
            <br> Project
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=accbusinessduration">
            <span class="fa fa-text-height holder-icon"></span>
            <br> Business Period
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=accbankaccount">
            <span class="fa fa-pencil-square-o holder-icon"></span>
            <br> Bank Accounts
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=acccashaccount">
            <span class="fa fa-map-marker holder-icon"></span>
            <br> Cash Accounts
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=cagroup">
            <span class="fa fa-film holder-icon"></span>
            <br> Chart of Accounts Admin
          </a>
        </div>                  
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=site/user_permission">
            <span class="fa fa-user holder-icon"></span>
            <br> User / Permission Management
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=companymaster">
            <span class="fa fa-bank holder-icon"></span>
            <br> Company Master
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=payee-master/admin-panel">
            <span class="fa fa-user holder-icon"></span>
            <br> Payer / Payee
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=expense-master">
            <span class="fa fa-pencil-square-o holder-icon"></span>
            <br> Expense Master
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=vehicles">
            <span class="fa fa-car holder-icon"></span>
            <br> Vehicle
          </a>
        </div>

      </div>
    </div>

    
</div> -->