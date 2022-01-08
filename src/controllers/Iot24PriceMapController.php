<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24PriceMap;
use Yii;
use yii\filters\AccessControl;

class Iot24PriceMapController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $calendar = Iot24PriceMap::createCalendar(Yii::$app->request->get('year',date('Y')));

        return $this->render('create',['dates' => $calendar]);
    }
}