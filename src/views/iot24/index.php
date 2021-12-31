<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('iot24meter/msg','iot');
?>
<div class="iot-index mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
            'id',
            'system_id',
            'device_id',
            'device_type',
            'increments',
            'values',
            'status',
            'created_at',
            'updated_at',
            'downloaded_at',
            'created_by',
            'updated_by'
        ],
    ]) ?>
</div>