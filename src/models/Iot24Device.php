<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;

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
 * @property integer $is_active
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
            'is_active' => Yii::t('iot24meter/msg', 'is_active')
        ];
    }

    public function rules(): array
    {
        return [
            [['endpoint'], 'required'],
            [['device_type_id', 'is_active'], 'integer'],
            [['is_active'], 'default', 'value' => 1],
            [['device_id', 'endpoint'], 'string', 'max' => 1024],
            [['device_name', 'device_type_name'], 'string', 'max' => 512],
            [['refresh_interval_minutes'], 'string', 'max' => 16],
            [['created_at', 'updated_at', 'pulse_frequency', 'aliases'], 'safe'],
            [['device_id', 'device_name', 'device_type_name', 'refresh_interval_minutes', 'endpoint'],
                'trim'],
            [['device_id', 'device_name', 'device_type_name', 'refresh_interval_minutes', 'endpoint'],
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

    public function beforeSave($insert): bool
    {
        if (is_array($this->aliases)) {
            $this->aliases = Json::encode($this->aliases);
        }

        if (is_array($this->pulse_frequency)) {
            $this->pulse_frequency = Json::encode($this->pulse_frequency);
        }

        if (!parent::beforeSave($insert)) {
            return false;
        }

        return true;
    }
}