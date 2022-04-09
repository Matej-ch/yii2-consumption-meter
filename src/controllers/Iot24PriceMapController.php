<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\models\Iot24Device;
use matejch\iot24meter\models\Iot24GlobalPrice;
use matejch\iot24meter\models\Iot24PriceMap;
use matejch\iot24meter\models\Iot24PriceMapSearch;
use matejch\iot24meter\services\CalendarExporter;
use matejch\iot24meter\services\CalendarImporter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;

class Iot24PriceMapController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'export', 'import', 'index', 'create-for-interval'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $searchModel = new Iot24PriceMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'globalPrice' => Iot24GlobalPrice::findOne(['year' => date('Y')]),
            'devices' => ArrayHelper::map(Iot24Device::find()->active()->select(['device_id', 'device_name'])->all(), 'device_id', 'device_name')
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $months = range(1, 12);
            $year = $post['DynamicModel']['year'];
            $price = $post['DynamicModel']['price'];
            foreach ($months as $month) {
                for ($d = 1; $d <= 31; $d++) {
                    $time = mktime(12, 0, 0, $month, $d, $year);
                    if ((int)date('m', $time) === $month) {

                        $startTime = new \DateTime(date('Y-m-d 00:00:00', $time));
                        $endTime = new \DateTime(date('Y-m-d 24:00:00', $time));

                        if (!Iot24PriceMap::find()->where(['from' => date('Y-m-d', $time) . " 00:00:00", 'to' => date('Y-m-d', $time) . " 00:15:00"])->exists()) {
                            $priceMapForInterval = new Iot24PriceMap([
                                'from' => date('Y-m-d', $time) . " 00:00:00",
                                'to' => date('Y-m-d', $time) . " 00:15:00",
                                'price' => $price
                            ]);
                            $priceMapForInterval->save();
                        }

                        while ($startTime < $endTime) {
                            $from = date('Y-m-d', $time) . " " . $startTime->modify('+15 minutes')->format('H:i:s');
                            $to = date('Y-m-d', $time) . " " . $startTime->modify('+15 minutes')->format('H:i:s');
                            if (!Iot24PriceMap::find()->where(['from' => $from, 'to' => $to])->exists()) {
                                $priceMapForInterval = new Iot24PriceMap([
                                    'from' => $from,
                                    'to' => $to,
                                    'price' => $price
                                ]);
                                $priceMapForInterval->save();
                            }
                        }
                    }
                }
            }

            Yii::$app->session->setFlash('info', Yii::t('iot24meter/msg', 'loading_finished'));
            return $this->redirect(['index']);
        }

        $calendarModel = new DynamicModel(["year", 'price']);
        $calendarModel->addRule(['year'], 'integer');
        $calendarModel->addRule(['year', 'price'], 'required');
        $calendarModel->addRule(['price'], 'number');
        $calendarModel->setAttributes(['year' => date('Y')]);

        return $this->render('create', [
            'model' => $calendarModel,
            'forInterval' => false,
        ]);
    }

    public function actionCreateForInterval()
    {
        $model = new Iot24PriceMap();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (empty($post['from_time']) || empty($post['to_time'])) {
                Yii::$app->session->setFlash('danger', Yii::t('iot24meter/msg', 'interval_not_set'));
                return $this->redirect(Yii::$app->request->referrer);
            }

            $startTime = \DateTime::createFromFormat('d.m.Y H:i:s', $post['from'] . ' ' . $post['from_time'] . ':00');
            $endTime = \DateTime::createFromFormat('d.m.Y H:i:s', $post['to'] . ' ' . $post['to_time'] . ':00');

            $saved = 0;
            while ($startTime < $endTime) {

                $from = $startTime->format('Y-m-d H:i:s');
                $to = $startTime->modify('+15 minutes')->format('Y-m-d H:i:s');

                if (!($priceMap = Iot24PriceMap::find()->where(['from' => $from, 'to' => $to])->one())) {
                    $priceMap = new Iot24PriceMap();
                    $priceMap->from = $from;
                    $priceMap->to = $to;
                }

                $priceMap->price = $post['Iot24PriceMap']['price'];

                if ($priceMap->save()) {
                    $saved++;
                }
            }

            Yii::$app->session->setFlash('success', Yii::t('iot24meter/msg', 'interval_price_saved', ['saved' => $saved]));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'forInterval' => true,
            'devices' => Iot24Device::find()->active()->all()
        ]);
    }

    public function actionExport(): Response
    {
        ini_set('max_execution_time', 2600);

        $calendarExportService = new CalendarExporter();

        try {
            $writer = $calendarExportService->create();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . urlencode("calendar.xlsx") . '"');
            $writer->save('php://output');
            exit();
        } catch (Exception|\PhpOffice\PhpSpreadsheet\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->redirect(['create']);
        }
    }

    public function actionImport(): Response
    {
        ini_set('max_execution_time', 2600);

        if (Yii::$app->request->isPost) {
            if ($file = UploadedFile::getInstanceByName('xls_file')) {
                if ($file->error > 0) {
                    Yii::$app->session->setFlash('danger', $this->showFileErrorMsg($file->error));
                    return $this->redirect(['index']);
                }

                $nameParts = explode('.', $file->name);
                $rows = (new CalendarImporter($nameParts[count($nameParts) - 1]))->load($file->tempName);

                $result = Iot24PriceMap::saveMultiple($rows);
            }
        }

        return $this->redirect(['create']);
    }

    public function showFileErrorMsg($errorCode): string
    {
        $messagesArray = [
            UPLOAD_ERR_OK => Yii::t('iot24meter/msg', 'UPLOAD_ERR_OK'),
            UPLOAD_ERR_INI_SIZE => Yii::t('iot24meter/msg', 'UPLOAD_ERR_INI_SIZE'),
            UPLOAD_ERR_FORM_SIZE => Yii::t('iot24meter/msg', 'UPLOAD_ERR_FORM_SIZE'),
            UPLOAD_ERR_PARTIAL => Yii::t('iot24meter/msg', 'UPLOAD_ERR_PARTIAL'),
            UPLOAD_ERR_NO_FILE => Yii::t('iot24meter/msg', 'UPLOAD_ERR_NO_FILE'),
            UPLOAD_ERR_NO_TMP_DIR => Yii::t('iot24meter/msg', 'UPLOAD_ERR_NO_TMP_DIR'),
            UPLOAD_ERR_CANT_WRITE => Yii::t('iot24meter/msg', 'UPLOAD_ERR_CANT_WRITE'),
            UPLOAD_ERR_EXTENSION => Yii::t('iot24meter/msg', 'UPLOAD_ERR_EXTENSION'),
        ];
        return $messagesArray[$errorCode];
    }
}