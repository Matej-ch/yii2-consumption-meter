<?php
/* @var $calendar array */
?>

<?php foreach ($calendar as $year => $months) { ?>

    <div><?= Yii::t('iot24meter/msg', 'year') ?><?= $year ?></div>

    <?php foreach ($months as $month => $days) { ?>
        <div>
            <?php
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
            ?>
            <div><?= Yii::t('iot24meter/msg', 'month') ?><?= $monthName ?></div>

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
