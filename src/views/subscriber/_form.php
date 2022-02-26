<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24Subscriber */
/* @var $form yii\widgets\ActiveForm */
/* @var $devices \matejch\iot24meter\models\Iot24Device[] */
?>

<div class="iot24-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <div style="display: flex;flex-direction: row;flex-wrap: wrap">
        <?php foreach ($devices as $device) { ?>
            <div>
                <h2><?= Html::checkbox("Iot24Subscriber[devices][$device->device_id][id]", 0, ['uncheck' => 0]) ?>
                    &nbsp;<?= $device->device_name ?></h2>
                <?php $channels = Json::decode($device->aliases) ?>

                <?php foreach ($channels as $id => $alias) { ?>
                    <div>
                        <?= Html::checkbox("Iot24Subscriber[devices][$device->device_id][$id]", 0, ['uncheck' => 0]) ?>
                        <?= $alias ?>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>
    </div>

    <div>
        <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>