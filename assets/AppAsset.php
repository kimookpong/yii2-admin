<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
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
    const MAIN_ASSET_VERSION = '?v=1.0';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'temp/vendor/fontawesome-free/css/all.min.css',
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        'temp/css/sb-admin-2.min.css',
        'css/site.css' . self::MAIN_ASSET_VERSION,
    ];
    public $js = [
        'temp/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'temp/vendor/jquery-easing/jquery.easing.min.js',
        'temp/js/sb-admin-2.min.js',
        'temp/vendor/chart.js/Chart.min.js',
        'temp/js/demo/chart-area-demo.js',
        'temp/js/demo/chart-pie-demo.js',
        'app/js/_lib.js' . self::MAIN_ASSET_VERSION,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
