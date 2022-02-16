<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\db\ActiveRecord;

class Iot24PriceMap extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'iot24_price_map';
    }

    public static function saveMultiple(array $rows)
    {
        foreach ($rows as $monthID => $interval) {

        }
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'string'],
            [['device_id'], 'string', 'max' => 512],
            [['channel', 'from', 'to'], 'string', 'max' => 256],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'device_id' => Yii::t('iot24meter/msg', 'device_id'),
            'channel' => Yii::t('iot24meter/msg', 'channel'),
            'from' => Yii::t('iot24meter/msg', 'from'),
            'to' => Yii::t('iot24meter/msg', 'to'),
            'price' => Yii::t('iot24meter/msg', 'price'),
            'created_at' => Yii::t('iot24meter/msg', 'created_at'),
            'updated_at' => Yii::t('iot24meter/msg', 'updated_at'),
        ];
    }
}