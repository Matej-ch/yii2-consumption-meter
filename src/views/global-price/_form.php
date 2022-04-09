<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24GlobalPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="iot24-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => 0.01, 'min' => 0]) ?>

    <?= $form->field($model, 'year')->textInput(['type' => 'number', 'step' => 1]) ?>

    <div>
        <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>