<?php

namespace matejch\iot24meter\commands;

use matejch\iot24meter\Iot24;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;

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

        $params['device'] = '';
        $params['interval'] = 'last_24';
        $rawData = \matejch\iot24meter\models\Iot24::getRawData($params);

        Yii::$app->mailer->htmlLayout = "";
        $message = Yii::$app->mailer->compose('@matejch/iot24meter/mail/notify')
            ->setFrom($module->sender)
            ->setTo(array_keys($module->subscribers))
            ->setSubject("Meranie odberu $date - Notifikacia");

        $message->send();

        return ExitCode::OK;
    }
}