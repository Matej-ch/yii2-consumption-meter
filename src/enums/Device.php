<?php

namespace matejch\iot24meter\enums;

class Device
{
    public CONST ELEKTROMETER = 'elektrometer';
    public CONST ELEKTROMETER_CHODBA = 'elektrometer_chodba';
    public CONST POTRUBIE = 'potrubie';

    public static function getList(): array
    {
        return [
            self::ELEKTROMETER => 'elektrometer',
            self::ELEKTROMETER_CHODBA => 'elektrometer_chodba',
            self::POTRUBIE => 'potrubie'
        ];
    }


}