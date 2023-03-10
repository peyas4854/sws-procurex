<?php

namespace App\Interfaces;

interface ExcelExportInterface
{
    public function download(string $exportClassName, array $bladeData, string $fileName='', string $sheetName='');

}
