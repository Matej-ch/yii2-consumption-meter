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
        'css/tui-date-picker.css',
        'css/tui-time-picker.css',
    ];

    public $js = [
        'js/tui-code-snippet.min.js',
        'js/tui-time-picker.min.js',
        'js/tui-date-picker.min.js',
        'js/tui-calendar.min.js',
        'js/calendar.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $depends = [];
}