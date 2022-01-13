<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24PriceMap;
use Yii;
use yii\caching\ExpressionDependency;
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
        $year = Yii::$app->request->get('year', date('Y'));

        $calendar = Yii::$app->cache->getOrSet("iot24_calendar", function () use ($year) {
            return Iot24PriceMap::createCalendar($year);
        }, 3600, new ExpressionDependency(['expression' => "year=$year"]));

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