<?php

use matejch\iot24meter\enums\Device;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \matejch\iot24meter\models\Iot24Search */

$this->title = Yii::t('iot24meter/msg','iot');
?>
<div class="iot-index mt-20 w-full px-4">

    <h1 class="mt-1 mb-2 text-xl"><?= $this->title ?></h1>

    <p>
        <?= Html::a(Yii::t('iot24meter/msg','load'),['load'],['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
            'system_id',
            'device_id',
            'device_type' => [
                'attribute' => 'device_type',
                'format' => 'raw',
                'value' => static function($model) {
                    return  Device::getList()[$model->device_type] ?? '';
                },
                'filter' => Html::activeDropDownList($searchModel,'device_type', Device::getList(), ['class' => 'form-control','prompt' => Yii::t('iot24meter/msg','choose')]),
            ],
            'increments',
            'values',
            'status' => [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => static function($model) {
                    return  $model->getStatuses()[$model->status] ?? '';
                },
                'filter' => Html::activeDropDownList($searchModel,'status', $searchModel->getStatuses(), ['class' => 'form-control','prompt' => Yii::t('iot24meter/msg','choose')]),
            ],
            'created_at',
            'updated_at',
            'downloaded_at',
            'updated_by'
        ],
    ]) ?>
</div>