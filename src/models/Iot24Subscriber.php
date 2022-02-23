<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * @property int $id
 * @property string $email
 * @property string $devices
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Iot24Subscriber extends ActiveRecord
{
    public static function tableName()
    {
        return 'iot24_subscriber';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'email' => Yii::t('iot24meter/msg', 'email'),
            'devices' => Yii::t('iot24meter/msg', 'devices'),
            'created_at' => Yii::t('iot24meter/msg', 'created_at'),
            'updated_at' => Yii::t('iot24meter/msg', 'updated_at'),
        ];
    }

    public function rules(): array
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['devices'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['devices'], 'trim'],
            [['devices'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->devices = Json::decode($this->devices);
    }

    public function beforeValidate(): bool
    {
        $this->devices = Json::encode($this->devices);

        if (!parent::beforeValidate()) {
            return false;
        }

        return true;
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