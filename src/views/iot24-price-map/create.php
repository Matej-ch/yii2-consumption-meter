<?php


/* @var $pages array */
/* @var $this yii\web\View */

/* @var $months array */

use matejch\iot24meter\enums\Device;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$year = Yii::$app->request->get('year');

$this->title = Yii::t('iot24meter/msg', 'year');

\matejch\iot24meter\assets\CalendarAsset::register($this);

?>

<!--<?php /*$this->beginBlock('devices'); */ ?>
<?php /*foreach (Device::getList() as $key => $device) { */ ?>
    <div class="device">
        <span class="font-bold pr">
            <? /*= $device */ ?>
            <input type="hidden" value="<? /*= $key */ ?>"
                   name="Iot24PriceMap[device_id]">
        </span>
        <input type="number" step="0.001" name="Iot24PriceMap[price]" class="w-full js-price-input">
    </div>

<?php /*} */ ?>
<?php /*$this->endBlock(); */ ?>-->

<div class="js-year w-full">

    <!--<?php
    /*
        ActiveForm::begin([
            'action' => ['iot24-price-map/create'],
            'method' => 'get',
            'id' => 'search-by-year',
            'options' => ['class' => 'flex-container px-2', 'style' => 'justify-content:start']]) */ ?>

    <label for="input-year" class="w-full max300">
        <? /*= Yii::t('iot24meter/msg', 'pick_year') */ ?>
        <? /*= Html::input('number', 'year', Yii::$app->request->get('year', date('Y')), ['step' => 1, 'min' => 2020, 'id' => "input-year", 'class' => 'form-control']) */ ?>
    </label>

    <div class="w-full max300">&nbsp;
        <? /*= Html::submitButton('Zobraziť', ['class' => 'btn btn-success', 'style' => 'display:block']) */ ?>
    </div>
    <?php /*ActiveForm::end() */ ?>-->

    <!--<div class="py-2 px-2">
        <? /*= LinkPager::widget([
            'pagination' => $pages,
            'maxButtonCount' => 12,
        ])
        */ ?>
    </div>-->


    <div class="py-2 px-2 font-bold text-3xl">
        <div id="calendar" style="height: 800px;"></div>
    </div>


    <!--<div class="py-2 px-2 font-bold text-3xl">
        <? /*= $year */ ?>

        <input type="checkbox" id="year-checkbox" name="year-checkbox"
               checked>
        <label for="year-checkbox">Označiť všetky</label>

    </div>

    <div class="px-2">
        <input type="text" placeholder="Lokálne filtrovanie podľa čísla alebo mena dňa"
               class="js-search w-full py px">
    </div>-->

    <!--<?php /*foreach ($months as $month => $days) { */ ?>
        <div class="<? /*= ($month % 2 === 0) ? 'bg-gray' : '' */ ?> px-2 js-month pb-2">
            <?php
    /*            $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                */ ?>
            <div class="text-2xl flex font-bold">
                <? /*= Yii::t('iot24meter/msg', $monthName) */ ?>
            </div>

            <div class="days-wrapper">
                <?php /*$dayCount = 0; */ ?>

                <? /*= $this->render('partials/_intervals') */ ?>

                <?php /*foreach ($days as $dayNumber => $day) { */ ?>
                    <div class="day js-day">
                        <div class="day-name">
                            <div class="font-bold text-xl">
                                <? /*= Yii::t('iot24meter/msg', $day['name']) */ ?>
                            </div>
                            <div class="day_circle js-select-full-day">
                                <? /*= date('d', strtotime($day['full_date'])) */ ?>
                            </div>
                        </div>

                        <div class="intervals-wrapper">

                            <?php /*foreach ($day['intervals'] as $i => $interval) { */ ?>

                                <?php /*if ($i === 0) { */ ?>
                                    <div class="interval js-interval">

                                        <? /*= $this->blocks['devices'] */ ?>

                                        <input type="hidden"
                                               value="<? /*= $day['intervals'][count($day['intervals']) - 1] */ ?>">
                                        <input type="hidden" value="<? /*= $interval */ ?>">
                                    </div>
                                    <?php /*continue; */ ?>
                                <?php /*} */ ?>

                                <?php /*$fullDayNum = $dayNumber; */ ?>
                                <?php /*$fullMonthNum = $month; */ ?>

                                <?php /*if ($fullDayNum < 10) {
                                    $fullDayNum = "0$fullDayNum";
                                } */ ?>
                                <?php /*if ($fullMonthNum < 10) {
                                    $fullMonthNum = "0$fullMonthNum";
                                } */ ?>

                                <div class="interval js-interval">

                                    <? /*= $this->blocks['devices'] */ ?>

                                    <input type="hidden"
                                           name="Iot24PriceMap[<? /*= $year */ ?>][<? /*= $fullMonthNum */ ?>][<? /*= $fullDayNum */ ?>][<? /*= $i */ ?>][from]"
                                           value="<? /*= "$year-$fullMonthNum-$fullDayNum {$day['intervals'][$i - 1]}" */ ?>">

                                    <input type="hidden"
                                           name="Iot24PriceMap[<? /*= $year */ ?>][<? /*= $fullMonthNum */ ?>][<? /*= $fullDayNum */ ?>][<? /*= $i */ ?>][to]"
                                           value="<? /*= "$year-$fullMonthNum-$fullDayNum $interval" */ ?>">
                                </div>

                            <?php /*} */ ?>
                        </div>
                    </div>
                    <?php /*if ($dayCount === 6) { */ ?>
                        <div class="w-full"></div>
                        <? /*= $this->render('partials/_intervals') */ ?>
                        <?php /*$dayCount = 0; */ ?>
                    <?php /*} else {
                        $dayCount++;
                    } */ ?>
                <?php /*} */ ?>


            </div>
        </div>

    <?php /*} */ ?>

    <div class="py-2 px-2">
        <? /*= LinkPager::widget([
            'pagination' => $pages,
            'maxButtonCount' => 12,
        ])
        */ ?>
    </div>-->

</div>