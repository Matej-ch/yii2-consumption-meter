<?php

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24Subscriber */
/* @var $devices \matejch\iot24meter\models\Iot24Device[] */

$this->title = Yii::t('iot24meter/msg', 'update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'iot'), 'url' => ['iot24/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iot24-subscriber-create mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'devices' => $devices
    ]) ?>

</div>