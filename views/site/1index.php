<?php
/* @var $this yii\web\View */
$this->title = 'Dashboard';
?>

        
        <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Last month Scholarships</p>
                                    <h3 class="title">20
                                        <small></small>
                                    </h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> APR - 2018
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">store</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Last Month Payment</p>
                                    <h3 class="title">10,000</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> JUL - 2018
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="red">
                                    <i class="material-icons">access_alarm</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">This Month Scholarships</p>
                                    <h3 class="title">21</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> AUG - 2018
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">payment</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">This Month Payments</p>
                                    <h3 class="title">10,500</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> AUG - 2018
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12"> <img src="../assets/img/grade-5.jpg" class="col-sm-12 img-responsive"/></div>
                    </div>


                </div>
            </div>




<?php
$script = <<< JS
    demo.initDashboardPageCharts();
JS;
$this->registerJs($script);
?>


