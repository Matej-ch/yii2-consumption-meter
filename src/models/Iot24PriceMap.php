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

    /**
     * Creates array of all intervals for all days in year
     *
     * Indexed first by year,
     * Next level keys are months
     * Third level are days in month
     * Third level contains name of the day full date and interval
     *
     * @param $year
     * @return array
     * @throws \Exception
     */
    public static function createCalendar($year): array
    {
        $dates= [];
        $months = range(1,12);

        foreach ($months as $month) {
            for($d = 1; $d<=31; $d++) {
                $time= mktime(12, 0, 0, $month, $d, $year);
                if ((int)date('m', $time) === $month) {
                    $dates[$year][$month][$d]['name'] = date('l', $time);
                    $dates[$year][$month][$d]['full_date'] = date('Y-m-d', $time);

                    $startTime = new \DateTime(date('Y-m-d 00:00:00', $time));
                    $endTime = new \DateTime(date('Y-m-d 24:00:00', $time));
                    while ($startTime < $endTime) {
                        $dates[$year][$month][$d]['intervals'][] = $startTime->modify('+15 minutes')->format('H:i:s');
                    }
                }
            }
        }

        return $dates;
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'string'],
            [['device_id'], 'string', 'max' => 512],
            [['channel','from','to'], 'string', 'max' => 256],
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