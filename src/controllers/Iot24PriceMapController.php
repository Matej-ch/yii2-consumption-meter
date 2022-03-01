<?php

namespace matejch\iot24meter\controllers;

use app\components\helpers\FileHelper;
use matejch\iot24meter\models\Iot24PriceMap;
use matejch\iot24meter\services\CalendarExporter;
use matejch\iot24meter\services\CalendarImporter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
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
                        'actions' => ['create', 'export', 'import', 'index'],
                        'allow' => true, 'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index', []);
    }

    public function actionCreate()
    {

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            echo '<pre>' . print_r($post, true) . '</pre>';
            die();
        }

        $calendarModel = new DynamicModel(["year", 'price']);
        $calendarModel->addRule(['year'], 'integer');
        $calendarModel->addRule(['year', 'price'], 'required');
        $calendarModel->addRule(['price'], 'number');
        $calendarModel->setAttributes(['year' => date('Y')]);

        return $this->render('create', [
            'model' => $calendarModel,
        ]);
    }

    public function actionExport(): Response
    {

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