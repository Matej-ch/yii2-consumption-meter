<?php
/* @var $calendar array */
?>

<?php foreach ($calendar as $year => $months) { ?>

    <div class="py-2 px-2 font-bold text-3xl">
        <?= Yii::t('iot24meter/msg', 'year') ?><?= $year ?>
    </div>

    <?php foreach ($months as $month => $days) { ?>
        <div class="<?= ($month % 2 === 0) ? 'bg-gray' : '' ?>">
            <?php
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
            ?>
            <div class="text-2xl">
                <?= Yii::t('iot24meter/msg', 'month') ?>
                <span class="font-bold"> <?= $monthName ?></span>
            </div>

            <?php foreach ($days as $day) { ?>
                <div><?= Yii::t('iot24meter/msg', $day['name']) ?></div>
                <div><?= $day['full_date'] ?></div>
                <div>
                    <?php foreach ($day['intervals'] as $interval) { ?>
                        <span><?= $interval ?></span>
                    <?php } ?>
                </div>

            <?php } ?>

        </div>

    <?php } ?>

<?php } ?>
