<?php

?>

<div class="intervals-column">
    <div class="day-name">
        <div class="font-bold text-xl">&nbsp;</div>
        <div class="day_circle js-select-full-day bg-white">&nbsp;</div>
    </div>

    <div class="">
        <?php
        $startTime = new \DateTime(date('Y-m-d 00:00:00'));
        $endTime = new \DateTime(date('Y-m-d 24:00:00'));
        while ($startTime < $endTime) { ?>

            <div class="interval-text">
                <span>
                    <?= $startTime->modify('+15 minutes')->format('H:i:s') ?>
                </span>
            </div>

        <?php } ?>
    </div>
</div>
