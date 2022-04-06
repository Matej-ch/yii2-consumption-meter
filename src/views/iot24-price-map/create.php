<?php

/* @var $this yii\web\View */

/* @var $model \matejch\iot24meter\models\Iot24PriceMap */

use matejch\iot24meter\assets\TimePickerAsset;
use yii\helpers\Html;
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

            <div>
                <label for="">OD</label>
                <?= yii\jui\DatePicker::widget(['name' => 'from']) ?>
                <input type="text" id="from_time" name="from_time">
            </div>


            <div>
                <label for="">DO</label>
                <?= yii\jui\DatePicker::widget(['name' => 'to']) ?>
                <input type="text" id="to_time" name="to_time">
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
