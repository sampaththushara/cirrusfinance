<?php
/* @var $this yii\web\View */
$this->title = 'Dashboard';
$this->params['selectedBtn'] = "admin";
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
                            <a href="index.php?r=mprovinciallist">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">Province</p>
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
                            <a href="index.php?r=mzonaledulist">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">Zonal Edu. Divisions</p>
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
                            <a href="index.php?r=mschoollist">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">School List</p>
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

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <a href="index.php?r=tblbank">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">Bank List</p>
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

                        
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <a href="index.php?r=tblbankbranch">
                            <div class="card card-stats">                                
                                <div class="card-content">
                                    <p class="category">Bank Branch List</p>
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

                                     

                </div>
            </div>

<?php
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;

echo '<br>';
//echo (Yii::$app->getUser()->identity->user_level);
//echo (Yii::$app->getUser()->identity->level_value);
echo GhostMenu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'items' => [
        [
            'label' => 'Backend routes',
            'items'=>UserManagementModule::menuItems()
        ],
        [
            'label' => 'Frontend routes',
            'items'=>[
                ['label'=>'Login', 'url'=>['/user-management/auth/login']],
                ['label'=>'Logout', 'url'=>['/user-management/auth/logout']],
                ['label'=>'Registration', 'url'=>['/user-management/auth/registration']],
                ['label'=>'Change own password', 'url'=>['/user-management/auth/change-own-password']],
                ['label'=>'Password recovery', 'url'=>['/user-management/auth/password-recovery']],
                ['label'=>'E-mail confirmation', 'url'=>['/user-management/auth/confirm-email']],
            ],
        ],
    ],
]);
?>


<?php
$script = <<< JS
    demo.initDashboardPageCharts();
JS;
$this->registerJs($script);
?>