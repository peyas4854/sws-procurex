<?php

namespace App\Http\Controllers;

use App\Interfaces\ExcelExportInterface;
use App\Models\Employee;
use App\Models\Requisition;
use App\Services\CostCenterService;
use App\Services\EmployeeService;
use App\Services\RequisitionService;
use App\Traits\MarkAsRead;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    use MarkAsRead;

    protected $requisitionService;
    protected $excelExport;

    public function __construct(ExcelExportInterface $excelExport)
    {
        $this->requisitionService = new RequisitionService();
        $this->excelExport = $excelExport;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->all();


        $costCenter = (new CostCenterService())->getDropdownList();
        $employees = (new EmployeeService())->getDropdownList();
        if ($request->has('action') && $request->input('action') == "excel") {
            $requisitions = $this->requisitionService->lists($data, true);

            $data = [
                'requisitions' => $requisitions
            ];
            return $this->excelExport->download('RequisitionExport', $data, 'RequisitionExcel', 'Sheet1');
        } else {
            $requisitions = $this->requisitionService->lists($data, false);
        }
        return view("requisitions.list", compact([
            "requisitions",
            "request",
            'costCenter',
            'employees'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        $user_id = $employee->id;
        return view("requisitions.create", compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Requisition $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $requisition = Requisition::query()->find($id);

        if (!$requisition) {
            $message = message("This requisition not available right now", 'error');
            session()->flash("message", $message);
            return redirect()->back();

        }
        if ($requisition->status == 'draft') {
            $message = message("This requisition not available right now", 'error');
            session()->flash("message", $message);
            return redirect()->back();
        } else {
            $this->markAsRead($request);
            $requisition_id = $id;
            return view('requisitions.view', compact('requisition_id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Requisition $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        $user_id = $requisition->employee_id;
        $requisition_id = $requisition->id;
        return view("requisitions.edit", compact(['user_id',
            'requisition_id',
            'requisition'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Requisition $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisition $requisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Requisition $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $requisition)
    {

        $response = $this->requisitionService->delete($requisition);
        if ($response === true) {
            $message = message("Requisition has been successfully deleted.");
        } else {
            $message = message("Requisition has not deleted.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();

    }

    public function print($id)
    {

        $requisition = Requisition::query()->where('id', $id)->with(['requisitionDetails', 'approval_team' => function ($query) {
            $query->where('status','approved')->orderBy('id');
        }, 'employee'])->first();

        return view('requisitions.print', compact('requisition'));
    }

    public function withdraw(Requisition $requisition)
    {
        $response = $this->requisitionService->withdraw($requisition);
        if ($response === true) {
            $message = message("Requisition has been successfully withdraw.");
        } else {
            $message = message("Requisition has not withdraw.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function export(Requisition $requisition)
    {
        $data = [
            'requisitions' => $requisition
        ];
        return $this->excelExport->download('RequisitionItemExport', $data, 'PrItemExcel', 'Sheet1');
    }
}
