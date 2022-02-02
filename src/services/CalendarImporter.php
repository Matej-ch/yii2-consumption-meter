<?php

namespace matejch\iot24meter\services;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class CalendarImporter
{
    /**
     * @var Xlsx|Xls
     */
    public $parser;

    public function __construct($type = 'xlsx')
    {
        $parsers = [
            'xlsx' => Xlsx::class,
            'xls' => Xls::class,
        ];

        $this->parser = new $parsers[strtolower($type)];
    }

    public function load(string $fileName): array
    {
        $this->parser->setReadDataOnly(true);
        $spreadsheet = $this->parser->load($fileName);
        $rows = [];
        $r = -1;
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $headingsArray = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];
            $headingsArray = array_map(static function ($val) {
                return trim($val);
            }, $headingsArray);

            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);

                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        $rows[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }
                }
            }

        }

        return $rows;
    }
}