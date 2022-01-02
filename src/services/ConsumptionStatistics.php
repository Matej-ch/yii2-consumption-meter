<?php

namespace matejch\iot24meter\services;

class ConsumptionStatistics
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function parse()
    {
        return  $this->data;
    }
}