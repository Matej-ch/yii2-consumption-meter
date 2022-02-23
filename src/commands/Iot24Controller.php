<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\models\Iot24Device;
use matejch\iot24meter\services\SensorDataLoader;
use Yii;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;

class Iot24Controller extends \yii\console\Controller
{
    /**
     * Load data from meters from iot24 api
     *
     * Endpoints are set in iot24_device table
     *
     * @return int
     */
    public function actionLoad(): int
    {
        $devices = Iot24Device::find()->select('endpoint')->all();

        if (!$devices) {
            echo $this->ansiFormat("No endpoints set\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        /** @var Iot24Device $device */
        foreach ($devices as $device) {
            $service = new SensorDataLoader($device->endpoint);

            foreach ($service->get() as $item) {
                $model = new \matejch\iot24meter\models\Iot24();
                $result = $model->upsert($item);

                if ($result) {
                    echo $this->ansiFormat(Yii::t('iot24meter/msg', 'save_success_msg') . "\n", BaseConsole::FG_GREEN);
                } else {
                    echo $this->ansiFormat(Yii::t('iot24meter/msg', 'save_success_msg') . "\n", BaseConsole::FG_RED);
                }
            }
        }

        return ExitCode::OK;
    }
}