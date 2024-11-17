<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/bootstrap.min.css',
        //'css/material-dashboard5438.css?v=1.2.0',
        //'css/demo.css',
        //'css/font-awesome.min.css',
        //'css/material-icons.css'
    ];
    public $js = [
        /*'js/arrive.min.js',
        'js/bootstrap.min.js',
        'js/bootstrap-notify.js',
        'js/chartist.min.js',
        'js/demo.js',
        'js/jquery.sharrre.js',
        ////'js/jquery-3.2.1.min.js',
        'js/material.min.js',
        'js/material-dashboard5438.js',
        'js/perfect-scrollbar.jquery.min.js',*/
        //'js/googleapis.js',
        //'js/IP_generalLib.js',
        //'//maps.googleapis.com/maps/api/js?key=AIzaSyBSaSxv01RBLnlu5EyBHLs57s-IquPaows'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
