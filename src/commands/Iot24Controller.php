<?php

namespace matejch\iot24meter\commands;

use yii\console\ExitCode;

class Iot24Controller extends \yii\console\Controller
{
    /**
     * Load data from meters from iot24 api
     *
     * all endpoints available are checked, based on array endpoints in module
     *
     * @return int
     */
    public function actionLoad(): int
    {
        return ExitCode::OK;
    }
}