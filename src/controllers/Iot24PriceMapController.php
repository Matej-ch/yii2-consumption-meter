<?php

namespace matejch\iot24meter\controllers;

use app\components\helpers\FileHelper;
use matejch\iot24meter\services\CalendarExporter;
use matejch\iot24meter\services\CalendarImporter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
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
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function showFileErrorMsg($errorCode): string
    {
        $messagesArray = [
            UPLOAD_ERR_OK => 'Žiadny error.',
            UPLOAD_ERR_INI_SIZE => 'Načítaný súbor presahuje upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'Načítaný súbor presahuje MAX_FILE_SIZE directive ktorá bola špecifikovaná v HTML formulári',
            UPLOAD_ERR_PARTIAL => 'Súbor bol iba čiastočne načítaný',
            UPLOAD_ERR_NO_FILE => 'Žiadny súbor načítaný',
            UPLOAD_ERR_NO_TMP_DIR => 'Chýba dočasný adresár',
            UPLOAD_ERR_CANT_WRITE => 'Zlyhalo zapisovanie súboru na disk',
            UPLOAD_ERR_EXTENSION => 'Načítanie súboru zastavilo by extension',
        ];
        return $messagesArray[$errorCode];
    }
}