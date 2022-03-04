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

            //echo '<pre>'.print_r(count($measurements),true).'</pre>';die();
            //echo '<pre>'.print_r($devices,true).'</pre>';
            foreach ($devices as $deviceID => $device) {
                //echo '<pre>$device before condition: '.print_r($device,true)."\n";
                if (!in_array('id',$device) || !isset($measurements[$deviceID])) {
                    continue;
                }


                //echo '<pre>'.print_r($measurements[$deviceID],true).'</pre>';
                echo '<pre>$deviceID: '.print_r($deviceID,true)."\n";
                echo '<pre>$device: '.print_r($device,true)."\n";
                /*echo '<pre>$measurements: '.print_r($measurements,true).'</pre>';
                echo '<pre>$deviceID: '.print_r($deviceID,true).'</pre>';die();*/
                /*foreach ($measurements[$deviceID] as $measurementsForDevice) {
                    $increments = Json::decode($measurementsForDevice['increments']);

                    foreach ($device as $deviceChannel) {

                        if($deviceChannel === 'id' && count($device) === 1) {

                        } else {

                            if($deviceChannel === 'id') { continue; }

                            if(isset($incrementsCounts[$deviceID][$deviceChannel])) {
                                $incrementsCounts[$deviceID][$deviceChannel] += ($increments[$deviceChannel] ?? 0);
                            } else {
                                $incrementsCounts[$deviceID][$deviceChannel] = ($increments[$deviceChannel] ?? 0);
                            }
                        }
                    }
                }*/
            }
            die();

            echo '<pre>'.print_r($incrementsCounts,true).'</pre>';die();
            die();

            Yii::$app->mailer->htmlLayout = '@matejch/iot24meter/mail/layouts/html';
            $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify', ['channelValues' => $incrementsCounts, 'date' => $date])
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
}