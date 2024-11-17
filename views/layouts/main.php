<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use adminlte\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\CompanyMaster;
use app\models\PayeeMaster;
use yii\helpers\Url;

AppAsset::register($this);
 //var_dump($this->params['breadcrumbs']);die(); 

$company_image = CompanyMaster::find()->where(['id' => 1])->one()->image;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  

  <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


  <!-- Font CSS (Via CDN) -->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>

  <!-- Theme CSS -->
  <link rel="stylesheet" type="text/css" href="css/skin/default_skin/css/theme.css">

  <!-- Style CSS -->
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- Admin Forms CSS -->
  <link rel="stylesheet" type="text/css" href="css/admin-tools/admin-forms/css/admin-forms.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="css/img/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body class="dashboard-page sb-l-o sb-r-c">

<?php $this->beginBody() ?>

  <!-- Start: Main -->
  <div id="main">

    <!-----------------------------------------------------------------+ 
       ".navbar" Helper Classes: 
    -------------------------------------------------------------------+ 
       * Positioning Classes: 
        '.navbar-static-top' - Static top positioned navbar
        '.navbar-static-top' - Fixed top positioned navbar

       * Available Skin Classes:
         .bg-dark    .bg-primary   .bg-success   
         .bg-info    .bg-warning   .bg-danger
         .bg-alert   .bg-system 
    -------------------------------------------------------------------+
      Example: <header class="navbar navbar-fixed-top bg-primary">
      Results: Fixed top navbar with blue background 
    ------------------------------------------------------------------->

    <!-- <div class="navbar-branding">
        <a class="navbar-brand" href="#">
          <b>My</b>Accounts
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
      </div>
      <form class="navbar-form navbar-left navbar-search" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search..." value="Search...">
        </div>
      </form> -->

    <!-- Start: Header -->
    <!-- <header class="navbar navbar-fixed-top"> -->
    <header class="navbar">
      <div class="row header-top">
          <div class="col-sm-12">
            <ul class="header-ul">
              <li id="navbar-sitename">
                <b>My</b>Accounts
              </li>
            </ul>
              <?php 
                use app\models\PostDatedCheque;
                use app\models\TblPayable;
                use app\models\TblReceivable;
                use app\models\PayerMaster;

                $list = PostDatedCheque::find()->andWhere(['chq_status'=>'Not Paid'])->andWhere(['<=', 'cheque_date', date("Y-m-d")])->all();
                $payable_list = TblPayable::find()->andWhere(['payable_status'=>'Not Paid'])->andWhere(['<=', 'due_date', date("Y-m-d")])->all();
                $receivable_list = TblReceivable::find()->andWhere(['receivable_status'=>'Not Receipt'])->andWhere(['<=', 'due_date', date("Y-m-d")])->all();
                $post_dated_list_count = count($list);
                $payable_list_count = count($payable_list);
                $receivable_list_count = count($receivable_list);
                $total_count = $post_dated_list_count + $payable_list_count + $receivable_list_count;
              ?>

              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown navbar-notifications">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <!-- <span class="ad ad-radio-tower fs18"></span> <span class="label label-warning"><?=$total_count?></span> -->
                    <i class="fa fa-bell-o"><sup><span class="label label-warning"><?=$post_dated_list_count?></span></sup></i>
                  </a>
                  <ul class="dropdown-menu media-list w350 animated animated-shorter fadeIn" role="menu">
                    <li class="dropdown-header">
                      <span class="dropdown-title"> Notifications - Post Dated Cheque</span>
                      <span class="label label-warning"><?=$post_dated_list_count?></span>
                    </li>

                    <script type="text/javascript">
                      function enc(str) {
                          var encoded = "";
                          for (i=0; i<str.length;i++) {
                              var a = str.charCodeAt(i);
                              var b = a ^ 123;    // bitwise XOR with any number, e.g. 123
                              encoded = encoded+String.fromCharCode(b);
                          }
                          return encoded;
                      }
                    </script>

                    <?php 
                    foreach ($list as $i => $account) {            
                      echo '<li class="media">';
                      //echo '<a class="media-left" href="#"> <img src="assets/img/avatars/5.jpg" class="mw40" alt="avatar"> </a>';
                      echo '<div class="media-body">';
                      echo '<h5 class="media-heading">Post Dated Cheque';
                      echo '<small class="text-muted"> - '.$account['cheque_date'].'</small>';
                      echo '</h5> Amount: '.number_format($account['chq_amount'],2);
                      echo ' | Cheque No: '.$account['cheque_no'];
                      echo '<br>Customer Name: '.$account['customer_name'];
                      $payee_id = PayeeMaster::find()->where(['payee_name' => $account['customer_name']])->one()->payee_id;
                      $cheque_id = $account["id"];
                      // $encrypted = strtr(base64_encode($id), '+/=', '-_,');
                      //$encrypted = base64_encode(gzcompress($id, 9));
                      ?>
                      <button class="btn-primary pull-right" onclick="getChequeUrlIds('<?php echo $payee_id; ?>','<?php echo $cheque_id; ?>')"> Add to Payment </button>
                      <?php
                      echo '</div>
                      </li>';
                    }
                    
                    ?>

                  </ul>
                </li>
                <li class="dropdown navbar-notifications">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <!-- <span class="ad ad-radio-tower fs18"></span> <span class="label label-warning"><?=$total_count?></span> -->
                    <i class="fa fa-bell-o"><sup><span class="label label-warning"><?=$payable_list_count?></span></sup></i>
                  </a>
                  <ul class="dropdown-menu media-list w350 animated animated-shorter fadeIn" role="menu">
                    <li class="dropdown-header">
                      <span class="dropdown-title"> Notifications - Payables</span>
                      <span class="label label-warning"><?=$payable_list_count?></span>
                    </li>

                    <?php 

                    // payable notifications
                    foreach ($payable_list as $i => $account) {            
                      echo '<li class="media">';
                      //echo '<a class="media-left" href="#"> <img src="assets/img/avatars/5.jpg" class="mw40" alt="avatar"> </a>';
                      echo '<div class="media-body">';
                      echo '<h5 class="media-heading">Payable';
                      echo '<small class="text-muted"> - '.$account['due_date'].'</small></h5>';
                      echo 'Amount: '.number_format($account['payable_amount'],2);
                      echo ' | Payable ID: '.$account['payable_id'].'<br>';
                      $payable_id = $account['payable_id'];
                      $payee_id = $account['payee_id'];
                      $payee_name = PayeeMaster::find()->where(['payee_id' => $payee_id])->one()->payee_name;
                      echo 'Payee Name: '.$payee_name;
                      //$payee_encrypted = base64_encode(gzcompress($payable_id, 9));
                      ?>

                      <button class="btn-primary pull-right" onclick="getPayableUrlIds('<?php echo $payee_id; ?>','<?php echo $payable_id; ?>')" > Add to Payment </button>
                      <?php
                      echo '</div>
                      </li>';
                    }
                    
                    ?>

                    <script type="text/javascript">
                      function getPayableUrlIds(payee_id,payable_id){
                        if( (typeof payee_id !== 'undefined') && (typeof payable_id !== 'undefined') ) {
                          var payeeId = payee_id.toString();
                          payeeId = enc(payeeId);
                          var payableId = payable_id.toString();
                          payableId = enc(payableId);
                          window.location = "index.php?r=accpaymentmain/create&payee_id="+payeeId+"&payable_ids="+payableId;
                        }
                      }
                      function getChequeUrlIds(payee_id,cheque_id){
                        if( (typeof payee_id !== 'undefined') && (typeof cheque_id !== 'undefined') ) {
                          var payeeId = payee_id.toString();
                          payeeId = enc(payeeId);
                          var chequeId = cheque_id.toString();
                          chequeId = enc(chequeId);
                          window.location = "index.php?r=accpaymentmain/create&payee_id="+payeeId+"&cheque_ids="+chequeId;
                        }
                      }
                    </script>

                  </ul>
                </li>

                 <li class="dropdown navbar-notifications">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <!-- <span class="ad ad-radio-tower fs18"></span> <span class="label label-warning"><?=$total_count?></span> -->
                    <i class="fa fa-bell-o"><sup><span class="label label-warning"><?=$receivable_list_count?></span></sup></i>
                  </a>
                  <ul class="dropdown-menu media-list w350 animated animated-shorter fadeIn" role="menu">
                    <li class="dropdown-header">
                      <span class="dropdown-title"> Notifications - Receivables</span>
                      <span class="label label-warning"><?=$receivable_list_count?></span>
                    </li>

                    <?php 

                    // receivable notifications
                    foreach ($receivable_list as $i => $account) {            
                      echo '<li class="media">';
                      //echo '<a class="media-left" href="#"> <img src="assets/img/avatars/5.jpg" class="mw40" alt="avatar"> </a>';
                      echo '<div class="media-body">';
                      echo '<h5 class="media-heading">Receivable';
                      echo '<small class="text-muted"> - '.$account['due_date'].'</small></h5>';
                      echo 'Amount: '.number_format($account['receivable_amount'],2);
                      echo ' | Receivable ID: '.$account['receivable_id'].'<br>';
                      $receivable_id = $account['receivable_id'];
                      $payer_id = $account['payer_id'];
                      $payer_name = PayerMaster::find()->where(['payer_id' => $payer_id])->one()->payer_name;
                      echo 'Payer Name: '.$payer_name;
                      $payer_encrypted = base64_encode(gzcompress($receivable_id, 9));
                      ?>
                      <button class="btn-primary pull-right" onclick="window.location.href = 'index.php?r=accreceiptmain/create&receivable_id=<?= $payer_encrypted; ?>';"> Add to Receipts </button>
                      <?php
                      echo '</div>
                      </li>';
                    }
                    ?>

                  </ul>
                </li>
            
            
                <!--li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="flag-xs flag-us"></span> US
                  </a>
                  <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                    <li>
                      <a href="javascript:void(0);">
                        <span class="flag-xs flag-in mr10"></span> Hindu </a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">
                        <span class="flag-xs flag-tr mr10"></span> Turkish </a>
                    </li>
                    <li>
                      <a href="javascript:void(0);">
                        <span class="flag-xs flag-es mr10"></span> Spanish </a>
                    </li>
                  </ul>
                </li-->
                <li class="menu-divider hidden-xs">
                  <!-- <i class="fa fa-circle"></i> -->
                </li>
                <li class="dropdown logout">
                  <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown"> <img src="<?php echo Yii::getAlias('@web').'/img/'.$company_image; ?>" alt="avatar" class="mw30 br64 mr15"> Welcome
                    <span class="caret caret-tp hidden-xs"></span>
                  </a>
                  <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
                    <!--li class="dropdown-header clearfix">
                      <div class="pull-left ml10">
                        <select id="user-status">
                          <optgroup label="Current Status:">
                            <option value="1-1">Away</option>
                            <option value="1-2">Offline</option>
                            <option value="1-3" selected="selected">Online</option>
                          </optgroup>
                        </select>
                      </div>

                      <div class="pull-right mr10">
                        <select id="user-role">
                          <optgroup label="Logged in As:">
                            <option value="1-1">Client</option>
                            <option value="1-2">Editor</option>
                            <option value="1-3" selected="selected">Admin</option>
                          </optgroup>
                        </select>
                      </div>

                    </li-->
                    <!--li class="list-group-item">
                      <a href="#" class="animated animated-short fadeInUp">
                        <span class="fa fa-envelope"></span> Messages
                        <span class="label label-warning">2</span>
                      </a>
                    </li>
                    <li class="list-group-item">
                      <a href="#" class="animated animated-short fadeInUp">
                        <span class="fa fa-user"></span> Friends
                        <span class="label label-warning">6</span>
                      </a>
                    </li>
                    <li class="list-group-item">
                      <a href="#" class="animated animated-short fadeInUp">
                        <span class="fa fa-gear"></span> Account Settings </a>
                    </li>
                    <li class="list-group-item">
                      <a href="#" class="animated animated-short fadeInUp">
                        <span class="fa fa-bell"></span> Activity  </a>
                    </li-->
                    <li class="dropdown-footer">
                      <a href="index.php?r=user-management/auth/logout" class="">
                      <span class="fa fa-power-off pr5"></span> Logout </a>
                    </li>
                  </ul>
                </li>
              </ul>
          </div>
        </div>

        <?php if(!empty($this->params['selectedBtn'])){
          $selectedBtn = $this->params['selectedBtn'];
        } ?>

        <div class="row new-navbar">
          <div class="col-sm-12 navbar-inner">
            <div class="navbar-menu" id="navbarMenu">
              <a href="index.php?r=site/index" class="<?php if (!empty($selectedBtn) && $selectedBtn == "home") {echo "active"; } ?>">Home</a>
              <a href="index.php?r=cagroup/dashboard" class="<?php if (!empty($selectedBtn) && $selectedBtn == "coa") {echo "active"; } ?>">Chart of Accounts</a>
              <a href="index.php?r=journalmain" class="<?php if (!empty($selectedBtn) && $selectedBtn == "journal") {echo "active"; } ?>">Journal Entry</a>
              <a href="index.php?r=invoice/create-invoice" class="<?php if (!empty($selectedBtn) && $selectedBtn == "invoice") {echo "active"; } ?>">Create Invoice</a>
              <a href="index.php?r=tbl-receivable" class="<?php if (!empty($selectedBtn) && $selectedBtn == "receivable") {echo "active"; } ?>">Receivables</a>
              <a href="index.php?r=accreceiptmain" class="<?php if (!empty($selectedBtn) && $selectedBtn == "receipt") {echo "active"; } ?>">Record a Receipt</a>
              <a href="index.php?r=tbl-payable" class="<?php if (!empty($selectedBtn) && $selectedBtn == "payable") {echo "active"; } ?>">Payables</a>
              <a href="index.php?r=accpaymentmain" class="<?php if (!empty($selectedBtn) && $selectedBtn == "payment") {echo "active"; } ?>">Make a Payment</a>                                       
              <a href="index.php?r=site/reports" class="<?php if (!empty($selectedBtn) && $selectedBtn == "reports") {echo "active"; } ?>">Reports</a>
              <a href="index.php?r=site/admin_main" class="<?php if (!empty($selectedBtn) && $selectedBtn == "admin") {echo "active"; } ?>">Admin Panel</a>
            </div>
          </div>
          <a href="index.php?r=site/index">
            <div class="logo">
              <img src="<?php echo Yii::getAlias('@web').'/img/'.$company_image; ?>">
            </div>
          </a>
        </div>        
      <!-- <div class="navbar-branding">
        <a class="navbar-brand" href="#">
          <b>My</b>Accounts
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
      </div>
      <form class="navbar-form navbar-left navbar-search" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search..." value="Search...">
        </div>
      </form>    -->

    <div class="navbar-bottom row">
      <?=
          Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'Home',
                'url' => Url::base().'/index.php?r=site/index',
                'template' => "<span class='glyphicon glyphicon-home'></span>  <li> {link} </li>\n"
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) 
        ?>  
    </div>
      
        
    </header>
    <!-- End : Header -->

    <!-----------------------------------------------------------------+ 
       "#sidebar_left" Helper Classes: 
    -------------------------------------------------------------------+ 
       * Positioning Classes: 
        '.affix' - Sets Sidebar Left to the fixed position 

       * Available Skin Classes:
         .sidebar-dark (default no class needed)
         .sidebar-light  
         .sidebar-light.light   
    -------------------------------------------------------------------+
       Example: <aside id="sidebar_left" class="affix sidebar-light">
       Results: Fixed Left Sidebar with light/white background
    ------------------------------------------------------------------->

    

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

      <!-- Start: Topbar-Dropdown -->
      <div id="topbar-dropmenu">
        <div class="topbar-menu row">
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="glyphicon glyphicon-inbox"></span>
              <span class="metro-title">Messages</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="glyphicon glyphicon-user"></span>
              <span class="metro-title">Users</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="glyphicon glyphicon-headphones"></span>
              <span class="metro-title">Support</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="fa fa-gears"></span>
              <span class="metro-title">Settings</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="glyphicon glyphicon-facetime-video"></span>
              <span class="metro-title">Videos</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile">
              <span class="glyphicon glyphicon-picture"></span>
              <span class="metro-title">Pictures</span>
            </a>
          </div>
        </div>
      </div>
      <!-- End: Topbar-Dropdown -->

      <!-- Start: Topbar -->

      <header id="topbar">
        

        <!-- <div class="topbar-left">
          <ol class="breadcrumb">
            <li class="crumb-active">
              <a href="dashboard.html">Dashboard</a>
            </li>
            <li class="crumb-icon">
              <a href="dashboard.html">
                <span class="glyphicon glyphicon-home"></span>
              </a>
            </li>
            <li class="crumb-link">
              <a href="#">Home</a>
            </li>
            <li class="crumb-trail">Dashboard</li>
          </ol>
        </div> -->
        
      </header>
      <!-- End: Topbar -->

      <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">
          <div class="row ">
            <div class="container">
              <?= $content ?>
            </div>
              
          </div>
        </section>
      <!-- End: Content -->

      <!-- Begin: Page Footer -->
      <footer id="content-footer">
        <div class="row">
          <div class="col-md-6">
            <span class="footer-legal">© <?=date("Y");?> SMSL</span>
          </div>
          <div class="col-md-6 text-right">
            <a href="#content" class="footer-return-top">
              <span class="fa fa-arrow-up"></span>
            </a>
          </div>
        </div>
      </footer>
      <!-- End: Page Footer -->

    </section>
    <!-- End: Content-Wrapper -->

    <!-- Start: Right Sidebar -->
    <aside id="sidebar_right" class="nano affix">

      <!-- Start: Sidebar Right Content -->
      <div class="sidebar-right-content nano-content">

        <div class="tab-block sidebar-block br-n">
          <ul class="nav nav-tabs tabs-border nav-justified hidden">
            <li class="active">
              <a href="#sidebar-right-tab1" data-toggle="tab">Tab 1</a>
            </li>
            <li>
              <a href="#sidebar-right-tab2" data-toggle="tab">Tab 2</a>
            </li>
            <li>
              <a href="#sidebar-right-tab3" data-toggle="tab">Tab 3</a>
            </li>
          </ul>
          <div class="tab-content br-n">
            <div id="sidebar-right-tab1" class="tab-pane active">

              <h5 class="title-divider text-muted mb20"> Server Statistics
                <span class="pull-right"> 2013
                  <i class="fa fa-caret-down ml5"></i>
                </span>
              </h5>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%">
                  <span class="fs11">DB Request</span>
                </div>
              </div>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%">
                  <span class="fs11 text-left">Server Load</span>
                </div>
              </div>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%">
                  <span class="fs11 text-left">Server Connections</span>
                </div>
              </div>

              <h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">132</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-success-dark mn">
                    <i class="fa fa-caret-up"></i> 13.2% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">212</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-success-dark mn">
                    <i class="fa fa-caret-up"></i> 25.6% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">82.5</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-danger mn">
                    <i class="fa fa-caret-down"></i> 17.9% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt40 mb20"> User Activity
                <span class="pull-right text-primary fw600">1 Hour</span>
              </h5>

              <div class="media">
                <a class="media-left" href="#">
                  <img src="assets/img/avatars/6.jpg" class="mw40 br64" alt="holder-img">
                </a>
                <div class="media-body">
                  <h5 class="media-heading">Article
                    <small class="text-muted">- 08/16/22</small>
                  </h5>Updated 36 days ago by
                  <a class="text-system" href="#"> Max </a>
                </div>
              </div>
              <div class="media">
                <a class="media-left" href="#">
                  <img src="assets/img/avatars/4.jpg" class="mw40 br64" alt="holder-img">
                </a>
                <div class="media-body">
                  <h5 class="media-heading">Richard
                    <small class="text-muted">@cloudesigns</small>
                    <small class="pull-right text-muted">6h</small>
                  </h5>Updated 36 days ago by
                  <a class="text-system" href="#"> Max </a>
                </div>
              </div>
              <div class="media">
                <a class="media-left" href="#">
                  <img src="assets/img/avatars/3.jpg" class="mw40 br64" alt="holder-img">
                </a>
                <div class="media-body">
                  <h5 class="media-heading">1,610 kcal
                    <span class="fa fa-caret-down text-primary pl5"></span>
                  </h5>Updated 36 days ago by
                  <a class="text-system" href="#"> Max </a>
                </div>
              </div>
              <div class="media">
                <a class="media-left" href="#">
                  <img src="assets/img/avatars/2.jpg" class="mw40 br64" alt="holder-img">
                </a>
                <div class="media-body">
                  <h5 class="media-heading">1,610 kcal
                    <span class="label label-xs label-system ml5">Featured</span>
                  </h5>Updated 36 days ago by
                  <a class="text-system" href="#"> Max </a>
                </div>
              </div>
              <div class="media">
                <a class="media-left" href="#">
                  <img src="assets/img/avatars/5.jpg" class="mw40 br64" alt="holder-img">
                </a>
                <div class="media-body">
                  <h5 class="media-heading">1,610 kcal</h5>
                  Updated ago by
                  <a class="text-system" href="#"> Max </a>
                </div>
                <a class="media-right pl30" href="#">
                  <span class="fa fa-pencil text-muted mb5"></span>
                  <br>
                  <span class="fa fa-remove text-danger-light"></span>
                </a>
              </div>
            </div>
            <div id="sidebar-right-tab2" class="tab-pane"></div>
            <div id="sidebar-right-tab3" class="tab-pane"></div>
          </div>
          <!-- end: .tab-content -->
        </div>

      </div>
    </aside>
    <!-- End: Right Sidebar -->

  </div>
  <!-- End: Main -->




  <!-- BEGIN: PAGE SCRIPTS -->
   <!-- jQuery -->
  <script src="vendor/jquery/jquery-1.11.1.min.js"></script>
  <script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- HighCharts Plugin -->
  <script src="vendor/plugins/highcharts/highcharts.js"></script>

  <!-- Sparklines Plugin -->
  <script src="vendor/plugins/sparkline/jquery.sparkline.min.js"></script>

  <!-- Simple Circles Plugin -->
  <script src="vendor/plugins/circles/circles.js"></script>

  <!-- JvectorMap Plugin + US Map (more maps in plugin/assets folder) -->
  <script src="vendor/plugins/jvectormap/jquery.jvectormap.min.js"></script>
  <script src="vendor/plugins/jvectormap/assets/jquery-jvectormap-us-lcc-en.js"></script> 

  <!-- Theme Javascript -->
  <script src="js/utility/utility.js"></script>
  <script src="js/demo/demo.js"></script>
  <script src="js/main.js"></script>
  <script src="js/custom.js"></script>

  <!-- Widget Javascript -->
  <script src="js/demo/widgets.js"></script>
  <script type="text/javascript">
  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core      
    Core.init();

    // Init Demo JS
    Demo.init();

    // Init Widget Demo JS
    // demoHighCharts.init();

    // Because we are using Admin Panels we use the OnFinish 
    // callback to activate the demoWidgets. It's smoother if
    // we let the panels be moved and organized before 
    // filling them with content from various plugins

    // Init plugins used on this page
    // HighCharts, JvectorMap, Admin Panels

    // Init Admin Panels on widgets inside the ".admin-panels" container
    $('.admin-panels').adminpanel({
      grid: '.admin-grid',
      draggable: true,
      preserveGrid: true,
      mobile: false,
      onStart: function() {
        // Do something before AdminPanels runs
      },
      onFinish: function() {
        $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

        // Init the rest of the plugins now that the panels
        // have had a chance to be moved and organized.
        // It's less taxing to organize empty panels
        demoHighCharts.init();
        runVectorMaps(); // function below
      },
      onSave: function() {
        $(window).trigger('resize');
      }
    });

    // Widget VectorMap
    function runVectorMaps() {

      // Jvector Map Plugin
      var runJvectorMap = function() {
        // Data set
        var mapData = [900, 700, 350, 500];
        // Init Jvector Map
        $('#WidgetMap').vectorMap({
          map: 'us_lcc_en',
          //regionsSelectable: true,
          backgroundColor: 'transparent',
          series: {
            markers: [{
              attribute: 'r',
              scale: [3, 7],
              values: mapData
            }]
          },
          regionStyle: {
            initial: {
              fill: '#E5E5E5'
            },
            hover: {
              "fill-opacity": 0.3
            }
          },
          markers: [{
            latLng: [37.78, -122.41],
            name: 'San Francisco,CA'
          }, {
            latLng: [36.73, -103.98],
            name: 'Texas,TX'
          }, {
            latLng: [38.62, -90.19],
            name: 'St. Louis,MO'
          }, {
            latLng: [40.67, -73.94],
            name: 'New York City,NY'
          }],
          markerStyle: {
            initial: {
              fill: '#a288d5',
              stroke: '#b49ae0',
              "fill-opacity": 1,
              "stroke-width": 10,
              "stroke-opacity": 0.3,
              r: 3
            },
            hover: {
              stroke: 'black',
              "stroke-width": 2
            },
            selected: {
              fill: 'blue'
            },
            selectedHover: {}
          },
        });
        // Manual code to alter the Vector map plugin to 
        // allow for individual coloring of countries
        var states = ['US-CA', 'US-TX', 'US-MO',
          'US-NY'
        ];
        var colors = [bgWarningLr, bgPrimaryLr, bgInfoLr, bgAlertLr];
        var colors2 = [bgWarning, bgPrimary, bgInfo, bgAlert];
        $.each(states, function(i, e) {
          $("#WidgetMap path[data-code=" + e + "]").css({
            fill: colors[i]
          });
        });
        $('#WidgetMap').find('.jvectormap-marker')
          .each(function(i, e) {
            $(e).css({
              fill: colors2[i],
              stroke: colors2[i]
            });
          });
      }

      if ($('#WidgetMap').length) {
        runJvectorMap();
      }
    }



  });
  </script>


  <!-- END: PAGE SCRIPTS -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

