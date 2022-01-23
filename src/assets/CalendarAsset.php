<?php

namespace matejch\iot24meter\assets;

use yii\web\AssetBundle;

class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@matejch/iot24meter/web';

    public $css = [
        'css/main.min.css',
        'css/tui-calendar.min.css',
    ];

    public $js = [
        'js/tui-calendar.min.js',
        'js/calendar.min.js',
    ];

    public $depends = [];
}