<?php

namespace matejch\iot24meter\models;

use matejch\iot24meter\enums\Device;
use Yii;


/**
 * @property int $id
 * @property integer $system_id
 * @property string|null $device_id
 * @property string|null $device_type
 * @property string|null $increments
 * @property string|null $values
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $downloaded_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Iot24 extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'iot24';
    }

    public function rules()
    {
        return [
            [['created_by','updated_by','system_id'],'integer'],
            [['increments','values'], 'string'],
            [['device_id'], 'string', 'max' => 512],
            [['device_type'], 'string', 'max' => 256],
            [['device_type'], 'in', 'range' => Device::getList()],
            [['device_type'], 'default', 'value' => Device::ELEKTROMETER],
            [['created_at','updated_at'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 10],
            [['status'],'default','value'=>'1'],
            [['status','increments','values','device_id','device_type','created_at','updated_at'], 'trim'],
            [['status','increments','values','device_id','device_type','created_at','updated_at'],
                'filter','filter'=>'strip_tags','skipOnArray' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('iot24meter/msg','id'),
            'system_id' => Yii::t('iot24meter/msg','system_id'),
            'device_id' => Yii::t('iot24meter/msg','device_id'),
            'device_type' => Yii::t('iot24meter/msg','device_type'),
            'increments' => Yii::t('iot24meter/msg','increments'),
            'values' => Yii::t('iot24meter/msg','values'),
            'status' => Yii::t('iot24meter/msg','status'),
            "created_at" => Yii::t('iot24meter/msg','created_at'),
            "updated_at" => Yii::t('iot24meter/msg','updated_at'),
            'downloaded_at' => Yii::t('iot24meter/msg','downloaded_at'),
            'created_by' => Yii::t('iot24meter/msg','created_by'),
            'updated_by' => Yii::t('iot24meter/msg','updated_by'),
        ];
    }
}