<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\Iot24;
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

        $devices = [];
        foreach (Iot24Subscriber::find()->each(10) as $subscriber) {
            foreach ($subscriber->devices as $id => $device) {

                if (in_array(1, $device, false)) {
                    $devices[$id] = 1;
                }
            }
        }

        $query = \matejch\iot24meter\models\Iot24::find()->select(['device_type', 'increments', 'created_at'])->where(['device_id' => array_keys($devices)]);
        $query->andWhere(new Expression("created_at >= NOW() - INTERVAL 1 DAY"));

        $measurements = $query->asArray()->orderBy(['created_at' => SORT_ASC])->all();
        if (empty($measurements)) {
            echo $this->ansiFormat("Data not found\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        $measurements = ArrayHelper::index($measurements, null, 'device_type');

        /** check all subscribers */
        foreach (Iot24Subscriber::find()->each(10) as $email => $devices) {

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

            Yii::$app->mailer->htmlLayout = '@matejch/iot24meter/mail/layouts/html';
            $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify', ['channelValues' => $incrementsCounts, 'date' => $date])
                ->setFrom($module->sender)
                ->setTo($email)
                ->setSubject("Meranie odberu $date - Notifikacia");

            $message->send();

        }

        return ExitCode::OK;
    }
}