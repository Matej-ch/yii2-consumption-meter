<?php

use yii\helpers\{Html, Json};
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\Iot24 */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="guide-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="px-1 py-1">
            <?= Html::submitButton(Yii::t('iot24meter/msg','save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>