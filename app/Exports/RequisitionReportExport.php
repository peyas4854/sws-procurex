<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class RequisitionReportExport implements  FromView,WithTitle
{
    protected $data;
    protected $sheetName;

    public function __construct(array $data, string $sheetName)
    {
        $this->data = $data;
        $this->sheetName = $sheetName;
    }
    public function title(): string
    {
        return $this->sheetName === '' ? 'Sheet 1' : $this->sheetName;
    }
    public function view(): View
    {
        $data = $this->data;
        return view('requisition-report.requisition-excel', compact('data'));
    }
}
