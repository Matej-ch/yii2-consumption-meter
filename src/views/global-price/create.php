<?php

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\models\Iot24GlobalPrice */

$this->title = Yii::t('iot24meter/msg', 'create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'iot'), 'url' => ['iot24/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'calendar'), 'url' => ['iot24-price-map/index']];
$this->params['breadcrumbs'][] = ['label' => 'Globálna cena', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iot24-global-price-create mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>