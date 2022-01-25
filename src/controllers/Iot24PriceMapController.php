<?php

namespace matejch\iot24meter\controllers;

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
                        'actions' => ['create', 'export', 'import'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate(): string
    {
        return $this->render('create', []);
    }

    public function export()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function import()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }
}