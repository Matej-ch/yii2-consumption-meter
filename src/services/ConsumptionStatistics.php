<?php

namespace matejch\iot24meter\services;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ConsumptionStatistics
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function parse($params)
    {
        $requestInterval = $params['interval'] ?? 'last_24';
        $requestChannel = $params['channel'] ?? 'all';
        if($requestChannel !== 'all') {
            $requestChannel = "kanal$requestChannel";
        }

        $result = $incrementsValues = [];
        foreach ($this->data as $sensorValue) {
            $increments = Json::decode($sensorValue['increments']);
            $increments = array_map(static function($val) { return (float)$val;},$increments);

            $incrementsValues[] = $increments;
            foreach ($increments as $name => $increment) {

                if($requestChannel !== 'all' && $name !== $requestChannel) {
                    continue;
                }

                $result[$name]  = [
                    'name' => $name,
                    'data' => []
                ];
            }
        }

        foreach ($result as $key => &$channel) {
            $channel['data'] = ArrayHelper::getColumn($incrementsValues,$key);
        }

        return array_values($result);
    }

    public function getDates(): array
    {
        $dates = [];
        if(isset($this->data) && !empty($this->data)) {
            return ArrayHelper::getColumn($this->data,'created_at');
        }

        return $dates;
    }
}