<?php

namespace matejch\iot24meter\controllers;

use Yii;
use yii\filters\AccessControl;

class Iot24Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','storage'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index',[

        ]);
    }

    public function actionUpdate()
    {

    }

    public function actionLoad()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }
}