<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $devices array */
/* @var $globalPrice \matejch\iot24meter\models\Iot24GlobalPrice|null */

/* @var $searchModel \matejch\iot24meter\models\Iot24PriceMapData */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('iot24meter/msg', 'calendar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'iot'), 'url' => ['iot24/index']];
$this->params['breadcrumbs'][] = $this->title;

//CalendarAsset::register($this);

?>

<div class="js-year w-full">

    <div class="flex">
        <p class="py px">
            <?= Html::a(Yii::t('iot24meter/msg', 'create_for_intervals'), ['create-for-interval'], ['class' => 'btn btn-primary']) ?>
        </p>

        <p class="py px">
            <?= Html::a(Yii::t('iot24meter/msg', 'export'), ['iot24-price-map-data/export'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php ActiveForm::begin([
            'id' => 'xls-invoice-form',
            'action' => ['iot24-price-map-data/import'],
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

    <div>
        <?php if ($globalPrice) { ?>
            <span style="font-weight: bold;">
                Globálna cena pre nezadané intervaly je nastavená na <?= $globalPrice->price ?>&euro; pre
                rok <?= $globalPrice->year ?>
            </span>
            <?= Html::a('Upraviť globálnu cenu', ['global-price/index'], ['class' => 'btn btn-primary']) ?>
        <?php } else { ?>
            Globálna cena pre nezadané intervaly ešte nebola nastavená. <?= Html::a('Nastaviť globálnu cenu', ['global-price/index'], ['class' => 'btn btn-danger']) ?>
        <?php } ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'device_id' => [
                'attribute' => 'device_id',
                'format' => 'raw',
                'value' => static function ($model) {
                    return $model->device->device_name ?? '';
                },
                'filter' => Html::activeDropDownList($searchModel, 'device_id', $devices, ['class' => 'form-control', 'prompt' => Yii::t('iot24meter/msg', 'choose')]),

            ],
            'channel',
            'price' => [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => static function ($model) {
                    return $model->price;
                },
            ],
            'from' => [
                'attribute' => 'from',
                'format' => 'raw',
                'value' => static function ($model) {
                    return "<div><span class='font-bold'>" . $model->getAttributeLabel('from') . ":</span> $model->from</div>";
                }
            ],
            'to' => [
                'attribute' => 'to',
                'format' => 'raw',
                'value' => static function ($model) {
                    return "<div><span class='font-bold'>" . $model->getAttributeLabel('to') . ":</span> $model->to</div>";
                }
            ],

            'created_at' => [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => static function ($model) {
                    return "<div><span class='font-bold'>" . $model->getAttributeLabel('created_at') . ":</span> $model->created_at</div>";
                }
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'value' => static function ($model) {
                    return "<div><span class='font-bold'>" . $model->getAttributeLabel('updated_at') . ":</span> $model->updated_at</div>";
                }
            ],
        ],
    ]) ?>

    <!--<div class="py px" style="display: flex; flex-direction: row">

        <div id="lnb">
            <div class="lnb-new-schedule">
                <button id="btn-new-schedule" type="button"
                        class="btn-cal btn-default btn-block lnb-new-schedule-btn"
                        data-toggle="modal">
                    <? /*= Yii::t('iot24meter/msg', 'new_record') */ ?>
                </button>
            </div>
            <div id="lnb-calendars" class="lnb-calendars">
                <div>
                    <div class="lnb-calendars-item">
                        <label>
                            <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                            <span></span>
                            <strong><? /*= Yii::t('iot24meter/msg', 'show_all') */ ?></strong>
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
                                <i class="calendar-icon ic_view_day"></i><? /*= Yii::t('iot24meter/msg', 'day') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                                <i class="calendar-icon ic_view_week"></i><? /*= Yii::t('iot24meter/msg', 'week') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                                <i class="calendar-icon ic_view_month"></i><? /*= Yii::t('iot24meter/msg', 'month') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                                <i class="calendar-icon ic_view_week"></i><? /*= Yii::t('iot24meter/msg', 'two_weeks') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                                <i class="calendar-icon ic_view_week"></i><? /*= Yii::t('iot24meter/msg', 'three_weeks') */ ?>
                            </a>
                        </li>
                        <li role="presentation" class="dropdown-divider"></li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-workweek">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek"
                                       checked>
                                <span class="checkbox-title"></span><? /*= Yii::t('iot24meter/msg', 'show_weekends') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-start-day-1">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                       value="toggle-start-day-1">
                                <span
                                    class="checkbox-title"></span><? /*= Yii::t('iot24meter/msg', 'start_week_on_monday') */ ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a class="dropdown-menu-title" role="menuitem" data-action="toggle-narrow-weekend">
                                <input type="checkbox" class="tui-full-calendar-checkbox-square"
                                       value="toggle-narrow-weekend">
                                <span class="checkbox-title"></span><? /*= Yii::t('iot24meter/msg', 'narrower_weekends') */ ?>
                            </a>
                        </li>
                    </ul>
                </span>
                <span id="menu-navi">
                    <button type="button" class="btn-cal btn-default btn-sm move-today"
                            data-action="move-today"><? /*= Yii::t('iot24meter/msg', 'today') */ ?>
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
    </div>-->

</div>