<?php

namespace App\Http\Controllers;

use App\Interfaces\ExcelExportInterface;
use App\Models\Requisition;
use App\Services\RequisitionReportService;
use Illuminate\Http\Request;
use PDF;

class RequisitionReportController extends Controller
{
    protected $requisitionReportService;
    protected $excelExport;


    public function __construct(RequisitionReportService $requisitionReportService,ExcelExportInterface $excelExport)
    {
        $this->middleware('auth');
        $this->requisitionReportService = $requisitionReportService;
        $this->excelExport = $excelExport;
        $this->middleware('permission:pr-report', ['only' => ['create', 'show']]);
    }

    public function create()
    {
        return view('requisition-report.create');
    }

    public function show(Request $request)
    {

        $data = $request->all();

        $reports = $this->requisitionReportService->report($data);

        if ($request->has('action') && $request->input('action') == "excel") {
            $reports = $this->requisitionReportService->report($data,true);

            $data = [
                'reports' => $reports,
                'request' => $request,
            ];
            return $this->excelExport->download('RequisitionReportExport',$data,'PrReportExcel','Sheet1');
        }
        if ($request->has('action') && $request->input('action') == "pdf") {
            $reports = $this->requisitionReportService->report($data,true);

            $pdf = PDF::loadView('requisition-report.requisition-pdf', compact('reports', 'request'))->setPaper('a4', 'landscape');
            return $pdf->download('PR_report_pdf');

        }
        return view('requisition-report.view', compact('reports', 'request'));
    }

}
