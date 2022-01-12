<?php
/* @var $calendar array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="js-year w-full">

    <?php

    ActiveForm::begin([
        'action' => ['iot24-price-map/create'],
        'method' => 'get',
        'id' => 'search-by-year',
        'options' => ['class' => 'flex-container px-2', 'style' => 'justify-content:start']]) ?>

    <label for="input-year" class="w-full max300">
        <?= Yii::t('iot24meter/msg', 'pick_year') ?>
        <?= Html::input('number', 'year', Yii::$app->request->get('year', date('Y')), ['step' => 1, 'min' => 2020, 'id' => "input-year", 'class' => 'form-control']) ?>
    </label>

    <div class="w-full max300">&nbsp;
        <?= Html::submitButton('Zobraziť', ['class' => 'btn btn-success', 'style' => 'display:block']) ?>
    </div>
    <?php ActiveForm::end() ?>

    <?php foreach ($calendar as $year => $months) { ?>

        <div class="py-2 px-2 font-bold text-3xl">
            <?= $year ?>
        </div>

        <?php foreach ($months as $month => $days) { ?>
            <div class="<?= ($month % 2 === 0) ? 'bg-gray' : '' ?> px-2 js-month pb-2">
                <?php
                $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                ?>
                <div class="text-2xl flex font-bold">
                    <?= Yii::t('iot24meter/msg', $monthName) ?>
                </div>

                <div class="days-wrapper">
                    <? $dayCount = 0; ?>
                    <?php foreach ($days as $day) { ?>
                        <div class="day js-day">
                            <div class="day-name">
                                <div class="font-bold text-xl">
                                    <?= Yii::t('iot24meter/msg', $day['name']) ?>
                                </div>
                                <div class="day_circle js-select-full-day">
                                    <?= date('d', strtotime($day['full_date'])) ?>
                                </div>
                            </div>

                            <div class="intervals-wrapper">
                                <?php foreach ($day['intervals'] as $i => $interval) { ?>

                                    <?php if ($i === 0) { ?>
                                        <div class="interval js-interval">
                                            <input type="hidden"
                                                   value="<?= $day['intervals'][count($day['intervals']) - 1] ?>">
                                            <input type="hidden" value="<?= $interval ?>">
                                        </div>
                                        <?php continue; ?>
                                    <?php } ?>

                                    <div class="interval">
                                        <input type="number" step="0.001" name="Iot24PriceMap[price]">
                                        <input type="hidden"
                                               name="Iot24PriceMap[<?= $year ?>][<?= $month ?>][<?= $day ?>][<?= $i ?>][from]"
                                               value="<?= "$year-$month-$day {$day['intervals'][$i - 1]}" ?>">

                                        <input type="hidden"
                                               name="Iot24PriceMap[<?= $year ?>][<?= $month ?>][<?= $day ?>][<?= $i ?>][to]"
                                               value="<?= "$year-$month-$day $interval" ?>">
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($dayCount === 6) { ?>
                            <div class="w-full"></div>
                            <?php $dayCount = 0; ?>
                        <?php } ?>
                        <?php $dayCount++; ?>
                    <?php } ?>


                </div>
            </div>

        <?php } ?>

    <?php } ?>
</div>