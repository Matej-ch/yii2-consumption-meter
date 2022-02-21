<?php

namespace matejch\iot24meter\enums;

class Device
{
    public const ELEKTROMETER = 'elektrometer';
    public const ELEKTROMETER_CHODBA = 'elektrometer_chodba';
    public const POTRUBIE = 'potrubie';
    public const ELEKTROMETER_3 = "elektrometer_3";
    public const ELEKTROMETER_3_CHODBA = "elektrometer3_chodba";
    public const ELEKTROMETER_5 = "elektrometer_5";
    public const ELEKTROMETER_6 = "elektrometer_6";

    public static function getList(): array
    {
        return [
            self::ELEKTROMETER => 'elektrometer',
            self::ELEKTROMETER_CHODBA => 'elektrometer_chodba',
            self::POTRUBIE => 'potrubie',
            self::ELEKTROMETER_3 => 'elektrometer_3',
            self::ELEKTROMETER_3_CHODBA => 'elektrometer3_chodba',
            self::ELEKTROMETER_5 => 'elektrometer_5',
            self::ELEKTROMETER_6 => 'elektrometer_6',
        ];
    }
}