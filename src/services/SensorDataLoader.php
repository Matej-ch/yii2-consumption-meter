<?php

namespace matejch\iot24meter\services;

use yii\helpers\Json;

class SensorDataLoader
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    private function load()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $data = curl_exec($ch);
        curl_close($ch);

        return Json::decode($data);
    }

    public function get()
    {
        $data = $this->load();

        if(empty($data)) {
            return [];
        }

        foreach ($data as $item) {

            $increments = [];
            $values = [];
            foreach ($item as $key => $itemData) {
                if($this->startsWith($key,'kanal')) {
                    $increments[$key] = $itemData;
                }

                if($this->startsWith($key,'value')) {
                    $values[$key] = $itemData;
                }
            }
            $item['increments'] = Json::encode($increments);
            $item['values'] = Json::encode($values);

            yield $item;
        }
    }

    private function startsWith ( $haystack, $needle ): bool
    {
        return strpos( $haystack , $needle ) === 0;
    }
}