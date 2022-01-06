<?php

namespace matejch\iot24meter\models;

use yii\db\ActiveRecord;

class Iot24PriceMap extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'iot24_price_map';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [];
    }
}