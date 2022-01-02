<?php

use matejch\iot24meter\enums\Device;
use matejch\iot24meter\models\Iot24;
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
    <?= Html::dropDownList('device',Yii::$app->request->get('device',Device::ELEKTROMETER),
        array_combine(
            array_keys(Device::getList()),
            array_map(static function($v){ return str_replace('_',' ',ucfirst($v)); }, Device::getList())),
        ['class' => 'form-control']) ?>
</label>

<label for="input-interval" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_interval') ?>
    <?= Html::dropDownList('from',Yii::$app->request->get('interval','this_month'),Iot24::getIntervalList(),['class' => 'form-control']) ?>
</label>

<label for="input-channel" class="w-full max300">
    <?= Yii::t('iot24meter/msg', 'pick_channel') ?>
    <?php $channels = array_merge(['all' => Yii::t('iot24meter/msg', 'all')],array_combine(range('A', 'Z'),range('A', 'Z'))) ?>
    <?= Html::dropDownList('channel',Yii::$app->request->get('channel','all'),$channels,['class' => 'form-control']) ?>
</label>

<div  class="w-full max300">&nbsp;
    <?= Html::submitButton('Zobraziť',['class'=>'btn btn-success', 'style' => 'display:block'])?>
</div>
<?php ActiveForm::end() ?>
