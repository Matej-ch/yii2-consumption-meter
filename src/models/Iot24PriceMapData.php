<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "iot24_price_map_data".
 *
 * @property int $id
 * @property float $price
 * @property string $channel
 * @property string $device_id
 * @property string $updated_at
 * @property string $created_at
 * @property string $from
 * @property string $to
 *
 */
class Iot24PriceMapData extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'iot24_price_map';
    }

    public static function saveMultiple(array $rows): bool
    {
        foreach ($rows as $monthID => $interval) {

            $monthNumber = $monthID;
            if ($monthID < 10) {
                $monthNumber = "0$monthID";
            }

            foreach ($interval as $days) {

                $from = $to = '';
                foreach ($days as $i => $price) {

                    if (empty($i)) {
                        continue;
                    }

                    if (strrpos($i, '.A1') !== false) {
                        $year = explode('.', $i)[0];

                        $from = "$year-$monthNumber-{day} $price";
                        continue;
                    }

                    if (strrpos($i, '.B1') !== false) {
                        $year = explode('.', $i)[0];

                        $to = "$year-$monthNumber-{day} $price";
                        continue;
                    }

                    if (empty($price)) {
                        continue;
                    }
                    $price = str_replace(',', '.', $price);

                    $day = $i;
                    if ($i < 10) {
                        $day = "0$i";
                    }

                    $fromDate = str_replace('{day}', $day, $from);
                    $toDate = str_replace('{day}', $day, $to);

                    if ($oneMap = self::findOne(['from' => $fromDate, 'to' => $toDate])) {
                        $oneMap->price = $price;
                        $oneMap->update();
                    } else {
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
        }

        return true;
    }

    public function rules(): array
    {
        return [
            [['price'], 'required'],
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

    public function getDevice(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Iot24Device::class, ['device_id' => 'device_id']);
    }
}