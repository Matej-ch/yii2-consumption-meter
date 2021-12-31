<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\Iot24;
use matejch\iot24meter\models\Iot24Search;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class Iot24Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','load','update'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $searchModel = new Iot24Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate()
    {
        return $this->redirect(['index']);
    }

    public function actionLoad()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id): ?Iot24
    {
        if (($model = Iot24::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('iot24meter/msg','Not found'));
    }
}