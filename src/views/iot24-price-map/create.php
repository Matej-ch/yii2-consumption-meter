<?php

/* @var $this yii\web\View */

use matejch\iot24meter\assets\CalendarAsset;

$this->title = 'Kalendár';

CalendarAsset::register($this);

?>

<div class="js-year w-full">

    <div class="py-2 px-2 font-bold text-3xl">

        <div id="menu">
            <span id="menu-navi">
                <button type="button" class="btn-today move-today" data-action="move-today">Dnes</button>
                <button type="button" class="move-day" data-action="move-prev">
                    <i class="calendar-icon" data-action="move-prev"> < </i>
                </button>
                <button type="button" class="move-day" data-action="move-next">
                    <i class="calendar-icon" data-action="move-next"> > </i>
                </button>
            </span>
            <span id="renderRange" class="render-range"></span>
        </div>

        <div id="calendar"></div>
    </div>


</div>