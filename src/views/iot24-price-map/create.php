<?php
/* @var $calendar array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="js-year">

    <?php

    ActiveForm::begin([
        'method' => 'get',
        'options' => ['class' => 'flex-container px-2', 'style' => 'justify-content:start']]) ?>

    <label for="input-year" class="w-full max300">
        <?= Yii::t('iot24meter/msg', 'pick_year') ?>
        <?= Html::input('number', 'year', Yii::$app->request->get('year', date('Y')), ['step' => 1, 'min' => 2020]) ?>
    </label>

    <div class="w-full max300">&nbsp;
        <?= Html::submitButton('Zobraziť', ['class' => 'btn btn-success', 'style' => 'display:block']) ?>
    </div>
    <?php ActiveForm::end() ?>

    <?php foreach ($calendar as $year => $months) { ?>

        <div class="py-2 px-2 font-bold text-3xl">
            <?= Yii::t('iot24meter/msg', 'year') ?><?= $year ?>
        </div>

        <?php foreach ($months as $month => $days) { ?>
            <div class="<?= ($month % 2 === 0) ? 'bg-gray' : '' ?> px-2 js-month">
                <?php
                $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                ?>
                <div class="text-2xl">
                    <?= Yii::t('iot24meter/msg', 'month') ?>
                    <span class="font-bold"> <?= Yii::t('iot24meter/msg', $monthName) ?></span>
                </div>

                <div class="days-wrapper">
                    <?php foreach ($days as $day) { ?>
                        <div class="day js-day">
                            <div><?= Yii::t('iot24meter/msg', $day['name']) ?> <?= date('d.m.Y', strtotime($day['full_date'])) ?></div>
                            <div class="intervals-wrapper">
                                <?php foreach ($day['intervals'] as $interval) { ?>
                                    <span><?= $interval ?></span>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>

        <?php } ?>

    <?php } ?>
</div>