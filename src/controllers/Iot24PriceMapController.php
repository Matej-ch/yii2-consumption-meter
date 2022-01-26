<?php

namespace matejch\iot24meter\controllers;

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
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $months = range(1, 12);
        $year = date('Y');
        $calendar = [];
        foreach ($months as $month) {
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if ((int)date('m', $time) === $month) {
                    $calendar[$month][$d]['name'] = date('l', $time);
                    $calendar[$month][$d]['full_date'] = date('Y-m-d', $time);

                    $startTime = new \DateTime(date('Y-m-d 00:00:00', $time));
                    $endTime = new \DateTime(date('Y-m-d 24:00:00', $time));
                    while ($startTime < $endTime) {
                        $calendar[$month][$d]['intervals'][] = $startTime->modify('+15 minutes')->format('H:i:s');
                    }
                }
            }
        }

        foreach ($calendar as $monthIndex => $month) {
            $worksheet = $spreadsheet->addSheet(new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, ''));
        }


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $writer->save("calendar.xls");

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionImport(): Response
    {
        return $this->redirect(Yii::$app->request->referrer);
    }
}