<?php

/* @var $this yii\web\View */

/* @var $model \matejch\iot24meter\models\Iot24PriceMap */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Kalendár', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iot24-calendar-create mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <div class="iot24-calendar-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'year')->textInput(['type' => 'number', 'step' => 1, 'min' => 2020]) ?>

        <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => 0.001]) ?>


        <div>
            <?= Html::submitButton('Uložiť', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>