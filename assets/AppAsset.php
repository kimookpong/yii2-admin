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
        'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=Noto+Sans+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        'template/assets/vendor/bootstrap-icons/bootstrap-icons.css',
        'template/assets/vendor/boxicons/css/boxicons.min.css',
        'template/assets/vendor/quill/quill.snow.css',
        'template/assets/vendor/quill/quill.bubble.css',
        'template/assets/vendor/remixicon/remixicon.css',
        'template/assets/vendor/simple-datatables/style.css',

        'template/assets/css/style.css',
        'css/site.css' . self::MAIN_ASSET_VERSION,
    ];
    public $js = [
        'template/assets/vendor/apexcharts/apexcharts.min.js',
        'template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'template/assets/vendor/chart.js/chart.umd.js',
        'template/assets/vendor/echarts/echarts.min.js',
        'template/assets/vendor/quill/quill.js',
        'template/assets/vendor/simple-datatables/simple-datatables.js',
        'template/assets/vendor/tinymce/tinymce.min.js',
        'template/assets/vendor/php-email-form/validate.js',
        'template/assets/js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
