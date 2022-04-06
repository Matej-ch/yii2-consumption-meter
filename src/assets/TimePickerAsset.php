<?php

namespace matejch\iot24meter\assets;

use yii\web\AssetBundle;
use yii\web\View;

class TimePickerAsset extends AssetBundle
{
    public $sourcePath = '@matejch/iot24meter/web';

    public $css = [
        'https://cdn.jsdelivr.net/npm/timepicker@1.13.18/jquery.timepicker.min.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/timepicker@1.13.18/jquery.timepicker.min.js',
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