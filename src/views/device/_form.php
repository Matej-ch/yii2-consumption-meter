<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="iot24-device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'endpoint')->textInput() ?>

    <div>
        <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>