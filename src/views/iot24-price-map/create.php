<?php

/* @var $this yii\web\View */

/* @var $model \matejch\iot24meter\models\Iot24PriceMap */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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