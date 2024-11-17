<?php 

// echo Yii::$app->user->id;
// die;
$this->params['selectedBtn'] = "admin";

?>
<div class="row table-layout table-clear-xs">

    <div class="col-xs-12 col-sm-4 br-a br-light bg-light pv20 ph30 va-t">

      <h4 class="micro-header">Payer / Payee</h4>
      <div class="row" id="content-type"><!-- 
 
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=payer-master/create">
            <span class="fa fa-user-plus holder-icon"></span>
            <br> Add Payer
          </a>
        </div>
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=payee-master/create">
            <span class="fa fa-user-plus holder-icon"></span>
            <br> Add Payee
          </a>
        </div> -->
 
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=payer-master/index">
            <span class="fa fa-users holder-icon"></span>
            <br> Payers
          </a>
        </div>
 
        <div class="col-xs-4 col-sm-6">
          <a class="holder-style p15 mb20 holder-active" href="index.php?r=payee-master/index">
            <span class="fa fa-users holder-icon"></span>
            <br> Payees
          </a>
        </div>

      </div>
    </div>

    
</div>