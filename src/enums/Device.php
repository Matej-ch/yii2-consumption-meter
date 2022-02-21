<?php

namespace matejch\iot24meter\enums;

class Device
{
    public const ELEKTROMETER = 'elektrometer';
    public const ELEKTROMETER_CHODBA = 'elektrometer_chodba';
    public const POTRUBIE = 'potrubie';
    public const ELEKTROMETER_3 = "elektrometer 3";
    public const ELEKTROMETER_3_CHODBA = "elektrometer3 chodba";
    public const ELEKTROMETER_5 = "elektrometer 5";
    public const ELEKTROMETER_6 = "elektrometer 6";

    public static function getList(): array
    {
        return [
            self::ELEKTROMETER => 'elektrometer',
            self::ELEKTROMETER_CHODBA => 'elektrometer_chodba',
            self::POTRUBIE => 'potrubie',
            self::ELEKTROMETER_3 => 'elektrometer 3',
            self::ELEKTROMETER_3_CHODBA => 'elektrometer3 chodba',
            self::ELEKTROMETER_5 => 'elektrometer 5',
            self::ELEKTROMETER_6 => 'elektrometer 6',
        ];
    }


}