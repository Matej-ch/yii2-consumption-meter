<?php

/* @var $this yii\web\View */

use matejch\iot24meter\assets\CalendarAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Kalendár';

CalendarAsset::register($this);

?>

<div class="js-year w-full">

    <div class="flex">

        <p class="py px">
            <?= Html::a(Yii::t('iot24meter/msg', 'create'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <p class="py px">
            <?= Html::a(Yii::t('iot24meter/msg', 'export'), ['iot24-price-map/export'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php ActiveForm::begin([
            'id' => 'xls-invoice-form',
            'action' => ['iot24-price-map/import'],
            'options' => ['class' => 'container-flex-new py px', 'style' => 'align-items:end', 'enctype' => 'multipart/form-data'],
        ]); ?>

        <label for="xls_file" style="margin-bottom: 0"><?= Yii::t('iot24meter/msg', 'excel_file') ?>
            <?= Html::fileInput('xls_file', null, ['class' => 'form-control', 'accept' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'id' => 'xls_file']) ?>
            <?= Html::hiddenInput('MAX_FILE_SIZE', '10000000') ?>
        </label>

        <?= Html::submitButton(Yii::t('iot24meter/msg', 'import'),
            ['class' => 'btn btn-success', 'id' => 'load-xls-file']) ?>

        <?php ActiveForm::end() ?>
    </div>


    <div class="py px" style="display: flex; flex-direction: row">

        <div id="lnb">
            <div class="lnb-new-schedule">
                <button id="btn-new-schedule" type="button"
                        class="btn-cal btn-default btn-block lnb-new-schedule-btn"
                        data-toggle="modal">
                    <?= Yii::t('iot24meter/msg', 'new_record') ?>
                </button>
            </div>
            <div id="lnb-calendars" class="lnb-calendars">
                <div>
                    <div class="lnb-calendars-item">
                        <label>
                            <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                            <span></span>
                            <strong><?= Yii::t('iot24meter/msg', 'show_all') ?></strong>
                        </label>
                    </div>
                </div>
                <div id="calendarList" class="lnb-calendars-d1">
                </div>
            </div>
        </div>
        <div id="right" style="flex: 1">
            <div id="menu">
                <span class="dropdown">
                    <button id="dropdownMenu-calendarType" class="btn-cal btn-default btn-sm dropdown-toggle"
                            type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                        <span id="calendarTypeName">Dropdown</span>&nbsp;
                        <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                                <i class="calendar-icon ic_view_day"></i><?= Yii::t('iot24meter/msg', 'day') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                                <i class="calendar-icon ic_view_week"></i><?= Yii::t('iot24meter/msg', 'week') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                                <i class="calendar-icon ic_view_month"></i><?= Yii::t('iot24meter/msg', 'month') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                                <i class="calendar-icon ic_view_week"></i><?= Yii::t('iot24meter/msg', 'two_weeks') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                                <i class="calendar-icon ic_view_week"></i><?= Yii::t('iot24meter/msg', 'three_weeks') ?>
                            </a>
                        </li>
                        <li role="presentation" class="dropdown-divider"></li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-workweek">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek"
                                       checked>
                                <span class="checkbox-title"></span><?= Yii::t('iot24meter/msg', 'show_weekends') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-start-day-1">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                       value="toggle-start-day-1">
                                <span
                                    class="checkbox-title"></span><?= Yii::t('iot24meter/msg', 'start_week_on_monday') ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-narrow-weekend">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                       value="toggle-narrow-weekend">
                                <span class="checkbox-title"></span><?= Yii::t('iot24meter/msg', 'narrower_weekends') ?>
                            </a>
                        </li>
                    </ul>
                </span>
                <span id="menu-navi">
                    <button type="button" class="btn-cal btn-default btn-sm move-today"
                            data-action="move-today"><?= Yii::t('iot24meter/msg', 'today') ?>
                    </button>
                    <button type="button" class="btn-cal btn-default btn-sm move-day" data-action="move-prev">
                        <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                    </button>
                    <button type="button" class="btn-cal btn-default btn-sm move-day" data-action="move-next">
                        <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                    </button>
                </span>
                <span id="renderRange" class="render-range"></span>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

</div>