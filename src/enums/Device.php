<?php

namespace matejch\iot24meter\enums;

class Device
{
    public CONST ELEKTROMETER = 'elektrometer';

    public static function getList(): array
    {
        return [
            self::ELEKTROMETER
        ];
    }


}