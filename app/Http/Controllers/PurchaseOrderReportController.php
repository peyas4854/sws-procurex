<?php

namespace App\Http\Controllers;

use App\Interfaces\ExcelExportInterface;
use App\Services\PurchaseOrderReportService;
use Illuminate\Http\Request;
use PDF;

class PurchaseOrderReportController extends Controller
{
    protected $purchaseOrderReportService;
    protected $excelExport;

    public function __construct(ExcelExportInterface $excelExport)
    {
        $this->purchaseOrderReportService = new PurchaseOrderReportService();
        $this->excelExport = $excelExport;
        $this->middleware('permission:po-report', ['only' => ['create', 'show']]);
    }

    public function create()
    {
        return view('purchase-order-report.create');
    }

    public function show(Request $request)
    {
        $data = $request->all();
        $reports = $this->purchaseOrderReportService->report($data);

        if ($request->has('action') && $request->input('action') == "excel") {

            $reports = $this->purchaseOrderReportService->report($data,true);

            $data = [
                'reports' => $reports,
                'request' => $request,
            ];
            return $this->excelExport->download('PurchaseOrderReportExport',$data,'PoReportExcel','Sheet1');
        }
        if ($request->has('action') && $request->input('action') == "pdf") {
            $reports = $this->purchaseOrderReportService->report($data,true);

            $pdf = PDF::loadView('purchase-order-report.pdf', compact('reports', 'request'))->setPaper('a4', 'landscape');
            return $pdf->download('PO_report_pdf');

        }
        return view('purchase-order-report.view', compact('reports','request'));

    }
}
