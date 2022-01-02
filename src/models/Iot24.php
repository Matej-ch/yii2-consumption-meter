<?php

namespace matejch\iot24meter\models;

use matejch\iot24meter\enums\Device;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


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
            [['created_by', 'updated_by', 'system_id'], 'integer'],
            [['increments', 'values'], 'string'],
            [['device_id'], 'string', 'max' => 512],
            [['device_type'], 'string', 'max' => 256],
            [['device_type'], 'in', 'range' => array_keys(Device::getList())],
            [['device_type'], 'default', 'value' => Device::ELEKTROMETER],
            [['created_at', 'updated_at'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 10],
            [['status'], 'default', 'value' => '1'],
            [['status', 'increments', 'values', 'device_id', 'device_type', 'created_at', 'updated_at'], 'trim'],
            [['status', 'increments', 'values', 'device_id', 'device_type', 'created_at', 'updated_at'],
                'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'system_id' => Yii::t('iot24meter/msg', 'system_id'),
            'device_id' => Yii::t('iot24meter/msg', 'device_id'),
            'device_type' => Yii::t('iot24meter/msg', 'device_type'),
            'increments' => Yii::t('iot24meter/msg', 'increments'),
            'values' => Yii::t('iot24meter/msg', 'values'),
            'status' => Yii::t('iot24meter/msg', 'status'),
            "created_at" => Yii::t('iot24meter/msg', 'created_at'),
            "updated_at" => Yii::t('iot24meter/msg', 'updated_at'),
            'downloaded_at' => Yii::t('iot24meter/msg', 'downloaded_at'),
            'created_by' => Yii::t('iot24meter/msg', 'created_by'),
            'updated_by' => Yii::t('iot24meter/msg', 'updated_by'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['downloaded_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'user' => [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
                'defaultValue' => 0
            ],
        ];
    }

    public function getStatuses(): array
    {
        return [
            '1' => 'zo zariadenia',
            '2' => 'manuálne zadaná',
        ];
    }

    public function upsert($data,$device): bool
    {
        if (self::find()->where(['system_id' => $data['id'], 'device_id' => $data['device_id']])->exists()) {
            return true;
        }

        $this->system_id = $data['id'];
        $this->device_id = $data['device_id'];
        $this->increments = $data['increments'];
        $this->values = $data['values'];
        $this->status = $data['status'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->device_type = $device;

        if ($this->save()) {
            return true;
        }

        return false;
    }

    public static function getRawData()
    {
        return [];
    }
}