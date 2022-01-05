<?php

namespace matejch\iot24meter\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Consumption extends Widget
{
    public $series = [];

    public $values = [];

    public function init()
    {
        parent::init();
        $this->prepareValues();
    }

    public function run(): string
    {
        if(empty($this->values)) {
            return '';
        }

        $html = Html::tag('span','Spotreba za vybrané obdobie: ',['class' => 'font-bold']);
        foreach ($this->values as $channel => $value) {
            $html .= Html::tag('div',"$channel: $value kW",['class' => 'px-2 py-1 border-r']);
        }
        return Html::tag('div',$html,['class' => 'flex']);
    }

    public function prepareValues(): void
    {
        foreach ($this->series as $series) {
            $this->values[$series['name']] = round((array_sum($series['data']) / 1000),3);
        }
    }
}