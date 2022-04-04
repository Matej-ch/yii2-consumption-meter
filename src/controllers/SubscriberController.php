<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24Device;
use matejch\iot24meter\models\Iot24Subscriber;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubscriberController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'create', 'update'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Iot24Subscriber::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id): Response
    {
        try {
            $model = $this->findModel($id);
            $model->delete();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', Yii::t('iot24meter/msg', 'Not deleted'));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreate()
    {
        $model = new Iot24Subscriber();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'devices' => Iot24Device::find()->where(['is_active' => 1])->all(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'devices' => Iot24Device::find()->where(['is_active' => 1])->all(),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Iot24Subscriber::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('iot24meter/msg', 'Not found'));
    }
}