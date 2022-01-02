<?php

namespace matejch\iot24meter\services;

use yii\helpers\ArrayHelper;

class ConsumptionStatistics
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function parse($params)
    {
        $interval = $params['interval'] ?? 'last_24';
        $channel = $params['channel'] ?? 'all';

        foreach ($this->data as $sensorValue) {

        }
        return  $this->data;
    }

    public function getDates(): array
    {
        //if(isset($this->values) && !empty($this->values)) {
            //return ArrayHelper::getColumn($this->values,'created_at');
        //}

        return [];
    }
}