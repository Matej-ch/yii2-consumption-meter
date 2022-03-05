<?php

/* @var $this yii\web\View */
/* @var $model \matejch\iot24meter\Iot24 */

$this->title = Yii::t('iot24meter/msg', 'update') . " " . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('iot24meter/msg', 'iot'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('iot24meter/msg', 'update');
?>
<div class="guide-update mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>