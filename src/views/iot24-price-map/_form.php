<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24PriceMap */
/* @var $form yii\widgets\ActiveForm */
/* @var $subcribers \matejch\iot24meter\models\Iot24Subscriber[] */
?>

<div class="iot24-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div style="display: flex;flex-direction: row;flex-wrap: wrap">
        <?php foreach ($subcribers as $subscriber) { ?>
            <div style="padding-left: 1em;padding-right: 1em">
                <h2><?= Html::checkbox("Iot24PriceMap[devices][$subscriber->device_id][id]", $model->devices[$subscriber->device_id]['id'] ?? 0, ['uncheck' => 0, 'id' => "device_$subscriber->device_id"]) ?>
                    &nbsp;<label for="device_<?= $subscriber->device_id ?>"><?= $subscriber->device_name ?></label></h2>
                <?php $channels = Json::decode($subscriber->aliases) ?>

                <?php foreach ($channels as $id => $alias) { ?>
                    <div>
                        <label>
                            <?= Html::checkbox("Iot24PriceMap[subscribers][$subscriber->device_id][$id]", $model->devices[$subscriber->device_id][$id] ?? 0, ['uncheck' => 0]) ?>
                            <?= $alias ?>
                        </label>
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