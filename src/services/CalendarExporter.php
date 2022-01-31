<?php

namespace matejch\iot24meter\services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Exception;

class CalendarExporter
{
    public function __construct()
    {

    }

    /**
     * Create Excel file for entire year
     *
     * One sheet is one month
     *
     * @return Xlsx
     * @throws Exception
     */
    public function create(): Xlsx
    {
        $spreadsheet = new Spreadsheet();
        $months = range(1, 12);
        $year = date('Y');
        $calendar = [];
        foreach ($months as $month) {

            $monthName = \DateTime::createFromFormat('!m', $month);
            $monthName = $monthName->format('F');

            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if ((int)date('m', $time) === $month) {
                    $calendar[$monthName][$d]['name'] = date('l', $time);
                    $calendar[$monthName][$d]['full_date'] = date('Y-m-d', $time);

                    $startTime = new \DateTime(date('Y-m-d 00:00:00', $time));
                    $endTime = new \DateTime(date('Y-m-d 24:00:00', $time));
                    while ($startTime < $endTime) {
                        $calendar[$monthName][$d]['intervals'][] = $startTime->modify('+15 minutes')->format('H:i:s');
                    }
                }
            }
        }

        foreach ($calendar as $monthName => $days) {

            $worksheet = $spreadsheet->addSheet(new Worksheet($spreadsheet, $monthName));

            foreach ($days as $dayIndex => $day) {
                $worksheet->setCellValueByColumnAndRow($dayIndex + 2, 1, $dayIndex);
            }

            $temp = 2;
            foreach ($days[1]['intervals'] as $i => $interval) {
                if ($i === 0) {
                    $worksheet->setCellValue("A{$temp}", $days[1]['intervals'][count($days[1]['intervals']) - 1]);
                    $worksheet->setCellValue("B{$temp}", $interval);
                    continue;
                }

                $worksheet->setCellValue("A{$temp}", $days[1]['intervals'][$i - 1]);
                $worksheet->setCellValue("B{$temp}", $interval);
                $temp++;
            }
        }
        $spreadsheet->removeSheetByIndex(0);

        return new Xlsx($spreadsheet);
    }
}