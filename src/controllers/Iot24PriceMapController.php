<?php

namespace matejch\iot24meter\controllers;

use matejch\iot24meter\services\CalendarExporter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

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
        return $this->redirect(Yii::$app->request->referrer);
    }
}