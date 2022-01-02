<?php

use matejch\iot24meter\enums\Device;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php

ActiveForm::begin([
    'action' => ['iot24/index'],
    'method' => 'get',
    'id' => 'filter-consumption','options' =>['class' => 'flex-container','style' => 'justify-content:start'] ]) ?>

<label for="input-device" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_device') ?>
    <?= Html::dropDownList('from',Yii::$app->request->get('device',Device::ELEKTROMETER),
        array_combine(
            array_keys(Device::getList()),
            array_map(static function($v){ return str_replace('_',' ',ucfirst($v)); }, Device::getList())),
        ['class' => 'form-control']) ?>
</label>

<label for="input-interval" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_interval') ?>
    <?= Html::dropDownList('from',Yii::$app->request->get('from','this_month'),[
        'last_24' => Yii::t('iot24meter/msg', 'last_24'),
        'last_week' => Yii::t('iot24meter/msg', 'this_week'),
        'this_month' => Yii::t('iot24meter/msg', 'this_month'),
        'this_year' => Yii::t('iot24meter/msg', 'this_year'),
    ],['class' => 'form-control']) ?>
</label>

<label for="input-channel" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_chanel') ?>
    <?= Html::dropDownList('from',Yii::$app->request->get('channel','all'),[
        'all' => Yii::t('iot24meter/msg', 'last_24'),
        'channelA' => Yii::t('iot24meter/msg', 'this_week'),
        'channelB' => Yii::t('iot24meter/msg', 'this_month'),
        'channelC' => Yii::t('iot24meter/msg', 'this_year'),
        'channelD' => Yii::t('iot24meter/msg', 'this_year'),
        'channelE' => Yii::t('iot24meter/msg', 'this_year'),
    ],['class' => 'form-control']) ?>
</label>

<label  class="w-full max300">&nbsp;
    <?= Html::submitButton('Zobraziť',['class'=>'btn btn-success', 'style' => 'display:block'])?>
</label>
<?php ActiveForm::end() ?>
