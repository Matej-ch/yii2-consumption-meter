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
            foreach ($interval as $days) {

                $from = $to = '';
                foreach ($days as $i => $price) {

                    if (empty($i)) {
                        continue;
                    }

                    if (strrpos($i, '.A1') !== false) {
                        $year = explode('.', $i)[0];
                        if ($monthID < 10) {
                            $monthID = "0$monthID";
                        }
                        $from = "$year-$monthID-{day} $price";
                    }

                    if (strrpos($i, '.B1') !== false) {
                        $year = explode('.', $i)[0];
                        if ($monthID < 10) {
                            $monthID = "0$monthID";
                        }
                        $to = "$year-$monthID-{day} $price";
                    }

                    $day = $i;
                    if ($i < 10) {
                        $day = "0$i";
                    }
                    $fromDate = str_replace('{day}', $day, $from);
                    $toDate = str_replace('{day}', $day, $to);
                    (new self([
                        'device_id' => '0',
                        'channel' => '0',
                        'price' => $price,
                        'from' => $fromDate,
                        'to' => $toDate,
                    ]))->save();
                }
            }
        }

        return true;
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