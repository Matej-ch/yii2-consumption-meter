<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Iot24PriceMap extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'iot24_price_map';
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'string'],
            [['name'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'name' => Yii::t('iot24meter/msg', 'name'),
            'created_at' => Yii::t('iot24meter/msg', 'created_at'),
            'updated_at' => Yii::t('iot24meter/msg', 'updated_at'),
        ];
    }

    public function getSubscribers(): ActiveQuery
    {
        return $this->hasMany(Iot24Subscriber::class, ['id' => 'subscriber_id'])
            ->viaTable('price_map_subscriber', ['price_map_id' => 'id']);
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