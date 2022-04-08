<?php

/* @var $this yii\web\View */
/* @var $devices array */

/* @var $model \matejch\iot24meter\models\Iot24PriceMap */

use matejch\iot24meter\assets\TimePickerAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm;

TimePickerAsset::register($this);

$this->title = Yii::t('iot24meter/msg', 'create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'iot'), 'url' => ['iot24/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'calendar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iot24-calendar-create mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <div class="iot24-calendar-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php if (isset($forInterval) && !empty($forInterval)) { ?>

            <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => 0.001, 'min' => 0]) ?>

            <div class="px-12" style="display: flex; flex-direction: row; gap: 2rem">
                <div>
                    <label for=""><?= Yii::t('iot24meter/msg', 'date_from') ?></label>
                    <?= yii\jui\DatePicker::widget(['name' => 'from', 'inline' => true]) ?>
                </div>

                <div>
                    <label for="from_time"><?= Yii::t('iot24meter/msg', 'time_from') ?></label>
                    <input type="text" id="from_time" name="from_time">
                </div>
            </div>

            <div class="px-12" style="display: flex; flex-direction: row; gap: 2rem">
                <div>
                    <label for=""><?= Yii::t('iot24meter/msg', 'date_to') ?></label>
                    <?= yii\jui\DatePicker::widget(['name' => 'to', 'inline' => true]) ?>
                </div>

                <div>
                    <label for="to_time"><?= Yii::t('iot24meter/msg', 'time_to') ?></label>
                    <input type="text" id="to_time" name="to_time">
                </div>
            </div>

            <div style="display: flex;flex-direction: row;flex-wrap: wrap">
                <?php foreach ($devices as $device) { ?>
                    <div style="padding-left: 1em;padding-right: 1em">
                        <h2><?= Html::checkbox("Iot24PriceMap[devices][$device->device_id][id]", $model->devices[$device->device_id]['id'] ?? 0, ['uncheck' => 0, 'id' => "device_$device->device_id"]) ?>
                            &nbsp;<label for="device_<?= $device->device_id ?>"><?= $device->device_name ?></label></h2>
                        <?php $channels = Json::decode($device->aliases) ?>

                        <?php foreach ($channels as $id => $alias) { ?>
                            <div>
                                <label>
                                    <?= Html::checkbox("Iot24PriceMap[devices][$device->device_id][$id]", $model->devices[$device->device_id][$id] ?? 0, ['uncheck' => 0]) ?>
                                    <?= $alias ?>
                                </label>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>


        <?php } else { ?>
            <?= $form->field($model, 'year')->textInput(['type' => 'number', 'step' => 1, 'min' => 2020]) ?>

            <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => 0.001]) ?>
        <?php } ?>

        <div>
            <?= Html::submitButton(Yii::t('iot24meter/msg', 'save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php
$scriptIndex = <<< JS
$('#from_time').timepicker({ 'step': 15,'timeFormat': 'G:i', 'show2400': true }); 
$('#to_time').timepicker({ 'step': 15,'timeFormat': 'G:i', 'show2400': true });

JS;
$this->registerJs($scriptIndex, View::POS_READY, 'scriptIndex'); ?>
