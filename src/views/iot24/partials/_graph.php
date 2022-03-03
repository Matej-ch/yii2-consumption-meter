<?php

use matejch\iot24meter\models\Iot24;
use matejch\iot24meter\widgets\Consumption;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $series array */
/* @var $dates array */
/* @var $channels array */
/* @var $devices array */
/* @var $device \matejch\iot24meter\models\Iot24Device */

?>

<?php

ActiveForm::begin([
    'action' => ['iot24/index'],
    'method' => 'get',
    'id' => 'filter-consumption', 'options' => ['class' => 'flex-container px-2', 'style' => 'justify-content:start']]) ?>

<label for="input-device" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_device') ?>
    <?= Html::dropDownList('device', Yii::$app->request->get('device', $device->device_id ?? 0),
        $devices,
        ['class' => 'form-control', 'prompt' => 'Výber...']) ?>
</label>

<label for="input-interval" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_interval') ?>
    <?= Html::dropDownList('interval', Yii::$app->request->get('interval', 'last_24'), Iot24::getIntervalList(), ['class' => 'form-control']) ?>
</label>

<label for="input-channel" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_channel') ?>
    <?= Html::dropDownList('channel', Yii::$app->request->get('channel'), $channels, ['class' => 'form-control']) ?>
</label>

<div class="w-full max300">&nbsp;
    <?= Html::submitButton('Zobraziť', ['class' => 'btn btn-success', 'style' => 'display:block']) ?>
</div>
<?php ActiveForm::end() ?>

<?= Consumption::widget(['series' => $series]) ?>

<div class="pt-4 mt-2">
    <?= Highcharts::widget([
        'scripts' => [
            'modules/exporting',
            'themes/grid-light',
        ],
        'options' => [
            'chart' => [
                'type' => 'line',
                'zoomType' => 'x',
            ],
            'title' => [
                'text' => "",
            ],
            'xAxis' => [
                'categories' => $dates
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Prírastok'
                ]
            ],
            'plotOptions' => [
                'line' => [
                    'dataLabels' => [
                        'enabled' => true
                    ],
                    'enableMouseTracking' => false
                ]
            ],

            'series' => $series
        ]
    ]) ?>
</div>
