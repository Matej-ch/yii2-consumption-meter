<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\enums\Device;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class DeviceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $devices = Device::getList();

        $devices = array_map(static function ($val) {
            return ucfirst(str_replace('_', ' ', $val));
        }, $devices);

        return ['devices' => $devices];
    }
}