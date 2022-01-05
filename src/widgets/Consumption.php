<?php

namespace matejch\iot24meter\widgets;

use yii\base\Widget;

class Consumption extends Widget
{
    public $series = [];

    public $values = [];

    public function init()
    {
        parent::init();
        $this->prepareValues();
    }

    public function run()
    {
        return '';
    }

    public function prepareValues()
    {

    }
}