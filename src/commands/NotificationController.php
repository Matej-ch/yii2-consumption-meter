<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\Iot24;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseConsole;
use yii\db\Expression;

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

        if(empty($module->subscribers) || empty($module->sender)) {
            echo $this->ansiFormat("No subscribers or sender set\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        $date = date("d.m.Y");

        $devices = [];
        foreach ($module->subscribers as $subscriber) {
            $devices[] = array_keys($subscriber);
        }

        $devices = array_merge([],...$devices);

        $query = \matejch\iot24meter\models\Iot24::find()->select(['device_type','increments','values','created_at'])->where(['device_type' => $devices]);
        $query->andWhere(new Expression("created_at >= NOW() - INTERVAL 1 DAY"));

        $measurements = $query->asArray()->orderBy(['created_at' => SORT_ASC])->all();
        if(empty($measurements)) {
            echo $this->ansiFormat("Data not found\n", BaseConsole::FG_YELLOW);
            return ExitCode::OK;
        }

        $measurements = ArrayHelper::index($measurements,null,'device_type');

        foreach ($module->subscribers as $subscriber) {

        }

        Yii::$app->mailer->htmlLayout = '@matejch/iot24meter/mail/layouts/html';
        $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify')
            ->setFrom($module->sender)
            ->setTo(array_keys($module->subscribers))
            ->setSubject("Meranie odberu $date - Notifikacia");

        $message->send();

        return ExitCode::OK;
    }
}