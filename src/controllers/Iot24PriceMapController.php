<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24PriceMap;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
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

    public function actionCreate(): string
    {
        if (Yii::$app->cache->exists('year')) {
            $year = Yii::$app->cache->get('year');
        } else {
            $year = Yii::$app->request->get('year', date('Y'));
            Yii::$app->cache->set('year', 1800);
        }

        if (Yii::$app->cache->exists('calendar') && (string)Yii::$app->request->get('year') === (string)Yii::$app->cache->get('year')) {
            $calendar = Yii::$app->cache->get('calendar');
        } else {
            $calendar = Iot24PriceMap::createCalendar($year);
            Yii::$app->cache->set('calendar', 1800);
        }

        $provider = new ArrayDataProvider([
            'allModels' => $calendar[$year],
            'pagination' => [
                'pageSize' => 1,
            ]
        ]);

        $pages = new Pagination(['totalCount' => count($calendar[$year]), 'defaultPageSize' => 1]);

        return $this->render('create', ['months' => $provider->getModels(), 'pages' => $pages]);
    }
}