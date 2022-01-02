<?php

namespace matejch\iot24meter\services;

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
}