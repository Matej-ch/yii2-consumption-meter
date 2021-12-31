<?php

namespace matejch\iot24meter\assets;

use yii\web\AssetBundle;

class Iot24Asset extends AssetBundle
{

    public $sourcePath = '@matejch/iot24meter/web';

    public $css = [
    ];

    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}