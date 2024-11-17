<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>G5BOS : <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php //$this->beginBody() ?>
    <!--div class="wrap"-->
        <?php /*
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
            */
        ?>


          
            <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="index.php" class="simple-text">
                    G5BOS
                </a>
            </div>
            <div class="sidebar-wrapper">            
                <ul class="nav" id="navlist">
                    <li>
                        <a href="index.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>                    
                    <li>
                        <a href="index.php?r=tstudentinfo">
                            <i class="material-icons">person_outline</i>
                            <p>Student Info</p>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?r=examdeptstudentlist">
                            <i class="material-icons">people_outline</i>
                            <p>Student Pool</p>
                        </a>
                    </li>

                    <?php if((Yii::$app->getUser()->identity->user_level)=='school'){ ?>
                        <li>
                            <a href="index.php?r=tstudentinfo/monthly_eligibility">
                                <i class="material-icons">toys</i>
                                <p>Bursary Process</p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php /*if((Yii::$app->getUser()->identity->user_level)=='zone'){ ?>
                        <li>
                            <a href="index.php?r=tbursaryprocessmaster/bursary_confirm">
                                <i class="material-icons">toys</i>
                                <p>Bursary Confirmation</p>
                            </a>
                        </li>
                    <?php }*/ ?>

                    <li>
                        <a href="index.php?r=site/reports">
                            <i class="material-icons">money</i>
                            <p>Reports</p>
                        </a>
                    </li> 
                    <?php 
                        $user_level = Yii::$app->getUser()->identity->user_level;
                        if($user_level=='admin' || $user_level=='superadmin'){ ?>
                            <li>
                                <a href="index.php?r=site/admin_panel">
                                    <i class="material-icons">business</i>
                                    <p>Admin Panel</p>
                                </a>
                            </li>                     
                    <?php } ?> 
                       


                    <li class="active-pro">
                        
                        
                        <a href="index.php?r=user-management/auth/logout">
                            <i class="material-icons">power_settings_new</i>
                            <p>Logout</p>
                        </a>                        
                    
                        <a href="#">
                            <hr>
                            <p>User : <?=Yii::$app->getUser()->identity->username?></p>
                            <p>Role : <?=$user_level?></p>
                        </a>
                    </li>

                </ul>


            </div>
            <div class="sidebar-background" style="background-image: url(../assets/img/sidebar-1.jpg) "></div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Grade 5 Bursay Online System </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>Welcome <?=Yii::$app->getUser()->identity->username?></p>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">power_settings_new</i>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="index.php?r=user-management/auth/change-own-password">Change Password</a>
                                    </li>
                                    <li>
                                        <a href="index.php?r=user-management/auth/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <!--li>
                                <a href="index.php?r=user-management/auth/logout" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                            </li-->
                        </ul>
                        <!--form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form-->
                    </div>
                </div>
            </nav>


            <?= $content ?>


            <footer class="footer">
                <div class="container-fluid">
                    <!--nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    About
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav-->
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://skymanagementsystems.com">Powered by SMSL</a>
                    </p>
                </div>
            </footer>
            
        </div>
               

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
