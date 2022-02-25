<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24Device;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
                        'actions' => ['index', 'delete', 'create', 'update', 'get'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Iot24Device::find(),
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
        } catch (NotFoundHttpException|StaleObjectException $e) {
            Yii::$app->session->setFlash('danger', 'Not deleted');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Iot24Device::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('site/errmsg', 'no_page'));
    }

    public function actionCreate()
    {
        $model = new Iot24Device();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
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
        ]);
    }

    public function actionGet(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $devices = Iot24Device::find()->asArray()->all();

        return ['devices' => ArrayHelper::map($devices, 'id', 'device_name')];
    }

}