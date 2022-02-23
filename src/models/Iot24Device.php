<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $device_id
 * @property string $endpoint
 * @property string $device_name
 * @property integer $device_type_id
 * @property string $device_type_name
 * @property string $refresh_interval_minutes
 * @property string $pulse_frequency
 * @property string $aliases
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Iot24Device extends ActiveRecord
{
    public static function tableName()
    {
        return 'iot24_device';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'endpoint' => Yii::t('iot24meter/msg', 'endpoint'),
            'device_id' => Yii::t('iot24meter/msg', 'device_id'),
            'device_name' => Yii::t('iot24meter/msg', 'device_name'),
            'device_type_id' => Yii::t('iot24meter/msg', 'device_type_id'),
            'device_type_name' => Yii::t('iot24meter/msg', 'device_type_name'),
            'refresh_interval_minutes' => Yii::t('iot24meter/msg', 'refresh_interval_minutes'),
            "pulse_frequency" => Yii::t('iot24meter/msg', 'pulse_frequency'),
            "aliases" => Yii::t('iot24meter/msg', 'aliases'),
            'created_at' => Yii::t('iot24meter/msg', 'created_at'),
            'updated_at' => Yii::t('iot24meter/msg', 'updated_at'),
        ];
    }

    public function rules(): array
    {
        return [
            [['endpoint'], 'required'],
            [['device_type_id'], 'integer'],
            [['device_id', 'endpoint'], 'string', 'max' => 1024],
            [['device_name', 'device_type_name'], 'string', 'max' => 512],
            [['refresh_interval_minutes'], 'string', 'max' => 16],
            [['pulse_frequency', 'aliases'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['device_id', 'device_name', 'device_type_name', 'refresh_interval_minutes', 'pulse_frequency', 'aliases', 'endpoint'],
                'trim'],
            [['device_id', 'device_name', 'device_type_name', 'refresh_interval_minutes', 'pulse_frequency', 'aliases', 'endpoint'],
                'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}