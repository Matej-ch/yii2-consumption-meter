<?php

namespace matejch\iot24meter\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@matejch/iot24meter/web';

    public $css = [
        'css/main.min.css',
        'css/tui-date-picker.css',
        'css/tui-time-picker.css',
        'css/tui-calendar.css',
        'css/calendar.min.css',
    ];

    public $js = [
        'js/tui-code-snippet.min.js',
        'js/tui-time-picker.min.js',
        'js/tui-date-picker.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js',
        'js/tui-calendar.min.js',
        'js/calendar.min.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}