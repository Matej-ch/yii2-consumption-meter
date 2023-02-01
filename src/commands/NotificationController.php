<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\Iot24;
use matejch\iot24meter\models\Iot24Device;
use matejch\iot24meter\models\Iot24Subscriber;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseConsole;
use yii\db\Expression;
use yii\helpers\Json;

class NotificationController extends Controller
{

    public $receiver;

    /**
     * number of days for interval in sql query
     * @var integer
     */
    public $interval = 1;

    public function options($actionID): array
    {
        return ['receiver', 'interval'];
    }

    public function optionAliases(): array
    {
        return ['r' => 'receiver', 'i' => 'interval'];
    }

    /**
     * Send notification to emails in config json file
     * Emails are under key subscribers
     *
     */
    public function actionSend(): int
    {
        $module = Iot24::getInstance();

        if (empty($module->sender)) {
            echo $this->ansiFormat("No subscribers or sender set\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        $date = date("d.m.Y");

        $deviceAliases = ArrayHelper::map(Iot24Device::find()->active()->select('device_id,aliases')->all(), 'device_id', static function ($model) {
            return Json::decode($model['aliases']);
        });

        /** iterate over subscribers */
        foreach (Iot24Subscriber::find()->each(10) as $subscriber) {

            /** get all devices from subscriber and channels */
            $devices = [];
            foreach ($subscriber->devices as $id => $device) {
                foreach ($device as $channelID => $channel) {
                    if (!empty($channel)) {
                        $devices[$id][] = $channelID;
                    }
                }
            }

            /** get measurements for devices */
            $query = \matejch\iot24meter\models\Iot24::find()->select(['device_id', 'increments', 'created_at'])->where(['device_id' => array_keys($devices)]);
            $query->andWhere(new Expression("created_at >= NOW() - INTERVAL 1 DAY"));

            $measurements = $query->asArray()->orderBy(['created_at' => SORT_ASC])->all();
            if (empty($measurements)) {
                echo $this->ansiFormat("Measurements for $subscriber->email for  not found\n", BaseConsole::FG_YELLOW);
                continue;
            }

            $measurements = ArrayHelper::index($measurements, null, 'device_id');

            $incrementsCounts = [];

            foreach ($devices as $deviceID => $device) {
                if (!in_array('id', $device) || !isset($measurements[$deviceID])) {
                    continue;
                }

                foreach ($measurements[$deviceID] as $measurementsForDevice) {
                    $increments = Json::decode($measurementsForDevice['increments']);

                    foreach ($device as $deviceChannel) {

                        if ($deviceChannel === 'id' && count($device) === 1) {
                            foreach ($increments as $incrementChannel => $incrementValue) {
                                if (isset($incrementsCounts[$deviceID][$incrementChannel])) {
                                    $incrementsCounts[$deviceID][$incrementChannel] += ($incrementValue ?? 0);
                                } else {
                                    $incrementsCounts[$deviceID][$incrementChannel] = ($incrementValue ?? 0);
                                }
                            }
                        } else {

                            if ($deviceChannel === 'id') {
                                continue;
                            }

                            if (isset($incrementsCounts[$deviceID][$deviceChannel])) {
                                $incrementsCounts[$deviceID][$deviceChannel] += ($increments[$deviceChannel] ?? 0);
                            } else {
                                $incrementsCounts[$deviceID][$deviceChannel] = ($increments[$deviceChannel] ?? 0);
                            }
                        }
                    }
                }
            }

            Yii::$app->mailer->htmlLayout = '@matejch/iot24meter/mail/layouts/html';
            $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify', ['channelValues' => $incrementsCounts, 'date' => $date, 'aliases' => $deviceAliases])
                ->setFrom($module->sender)
                ->setTo($subscriber->email)
                ->setSubject("Meranie odberu $date - Notifikacia");

            $message->send();
        }

        /** check all subscribers */
        foreach (Iot24Subscriber::find()->each(10) as $subscriber) {

            $incrementsCounts = [];
            /** check all devices for subscriber */
            foreach ($devices as $deviceKey => $device) {
                if (!isset($measurements)) {
                    continue;
                }

                /** get measurements fro device type */
                foreach ($measurements[$deviceKey] as $measurement) {
                    $increments = Json::decode($measurement['increments']);

                    if (empty($device)) {
                        foreach ($increments as $channel => $increment) {

                            if (!isset($incrementsCounts[$channel])) {
                                $incrementsCounts[$channel] = 0;
                            }

                            $incrementsCounts[$channel] += $increment;
                        }
                    } else {
                        foreach ($increments as $channel => $increment) {
                            if (!in_array($channel, $device, true)) {
                                continue;
                            }

                            if (!isset($incrementsCounts[$channel])) {
                                $incrementsCounts[$channel] = 0;
                            }

                            $incrementsCounts[$channel] += $increment;
                        }
                    }
                }
            }

        }

        return ExitCode::OK;
    }

    public function actionSendAll(): int
    {
        $module = Iot24::getInstance();

        $receiver = $this->receiver ?? $module->receiver;

        if (strlen($module->sender) < 0 || strlen($receiver) < 0) {
            echo $this->ansiFormat("No receiver or sender set\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        $iotDevices = Iot24Device::find()->active()->select('device_id,device_name,aliases')->all();

        $deviceNames = ArrayHelper::map($iotDevices, 'device_id', 'device_name');

        $deviceAliases = ArrayHelper::map($iotDevices, 'device_id', static function ($model) {
            return Json::decode($model['aliases']);
        });

        /** get measurements for devices */
        $query = \matejch\iot24meter\models\Iot24::find()->select(['device_id', 'increments', 'created_at'])->where(['device_id' => array_keys($deviceAliases)]);
        $query->andWhere(new Expression("created_at >= NOW() - INTERVAL :interval DAY", [':interval' => $this->interval]));

        $measurements = $query->asArray()->orderBy(['created_at' => SORT_ASC])->all();
        $measurements = ArrayHelper::index($measurements, null, 'device_id');

        $preparedData = [];

        foreach ($measurements as $deviceID => $deviceMeasurements) {
            $preparedData[$deviceID] = [];

            $deviceAlias = $deviceAliases[$deviceID];

            foreach ($deviceMeasurements as $deviceMeasurement) {
                $increments = Json::decode($deviceMeasurement['increments']);

                foreach ($increments as $channelID => $increment) {
                    if (isset($preparedData[$deviceID][$deviceAlias[$channelID]])) {
                        $preparedData[$deviceID][$deviceAlias[$channelID]] += $increment;
                    } else {
                        $preparedData[$deviceID][$deviceAlias[$channelID]] = $increment;
                    }
                }
            }
        }

        Yii::$app->mailer->htmlLayout = '@matejch/iot24meter/mail/layouts/html';
        $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify-all', ['preparedData' => $preparedData, 'devices' => $deviceNames])
            ->setFrom($module->sender)
            ->setTo($receiver)
            ->setSubject("Meranie odberu 24 hodín - Notifikácia");

        if ($message->send()) {
            echo $this->ansiFormat("Email odoslaný\n", BaseConsole::FG_GREEN);
        } else {
            echo $this->ansiFormat("Email sa nepodarilo odoslať\n", BaseConsole::FG_RED);
        }

        return ExitCode::OK;
    }
}