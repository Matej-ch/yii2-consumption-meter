<?php

/* @var $this yii\web\View */

$this->title = Yii::t('iot24meter/msg', 'year');

\matejch\iot24meter\assets\CalendarAsset::register($this);

?>

<div class="js-year w-full">

    <div class="py-2 px-2 font-bold text-3xl">
        <div id="calendar" style="height: 100vh"></div>
    </div>


</div>