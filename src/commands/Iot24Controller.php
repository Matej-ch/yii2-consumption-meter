<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\Iot24;
use matejch\iot24meter\services\SensorDataLoader;
use Yii;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;

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
        $module = Iot24::getInstance();

        if(empty($module->endpoints)) {
            echo $this->ansiFormat("No endpoints set\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        foreach ($module->endpoints as $endpoint) {
            $service = new SensorDataLoader($endpoint);

            foreach ($service->get() as $item) {
                $model = new \matejch\iot24meter\models\Iot24();
                $result = $model->upsert($item);

                if($result) {
                    echo $this->ansiFormat(Yii::t('iot24meter/msg','save_success_msg',['device' => $model->device_id])."\n", BaseConsole::FG_GREEN);
                } else {
                    echo $this->ansiFormat(Yii::t('iot24meter/msg','save_success_msg',['device' => $item['device_id']])."\n", BaseConsole::FG_RED);
                }
            }
        }

        return ExitCode::OK;
    }
}