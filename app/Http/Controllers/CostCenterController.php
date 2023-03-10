<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostCenter\SaveFormRequest;
use App\Http\Requests\CostCenter\UpdateFormRequest;
use App\Models\CostCenter;
use App\Services\CostCenterService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;


class CostCenterController extends Controller
{
    protected $costCenterService;
    protected $employeeService;

    public function __construct()
    {
        $this->costCenterService = new CostCenterService();
        $this->employeeService = new EmployeeService();
        // Initiate Permission
        $this->middleware('permission:cost-center-list', ['only' => ['index']]);
        $this->middleware('permission:cost-center-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cost-center-view', ['only' => ['show']]);
        $this->middleware('permission:cost-center-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cost-center-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $cost_centers = $this->costCenterService->lists($data);

        $search = $request->search;

        return view("cost_center.list", compact(["cost_centers", "search"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("cost_center.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {
        $validatedData = $request->validated();

        $cost_center = $this->costCenterService->updateOrCreate($validatedData);

        if (is_null($cost_center) === false) {
            $message = message("CostCenter has been successfully created.");
        } else {
            $message = message("CostCenter has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function show(CostCenter $cost_center)
    {
        return view("cost_center.view", compact("cost_center"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(CostCenter $cost_center)
    {

        $financeAppvovalIds = $cost_center->financeApprover->pluck('id')->toArray();
        $buheadIds = $cost_center->buHeads->pluck('id')->toArray();
        $preSelectedBuHead = $this->employeeService->getPreSelectedList($buheadIds);
        $preSelectedFinance = $this->employeeService->getPreSelectedList($financeAppvovalIds);
        return view("cost_center.edit", compact([
            "cost_center",
            'preSelectedFinance',
            'financeAppvovalIds',
            'preSelectedBuHead',
            'buheadIds'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request)
    {
        $validatedData = $request->validated();

        $cost_center = $this->costCenterService->updateOrCreate($validatedData);

        if (is_null($cost_center) === false) {
            $message = message("CostCenter has been successfully updated.");
        } else {
            $message = message("CostCenter has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->route('cost-center.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenter $costCenter, $id = null)
    {
        if ($costCenter->requisitions()->exists()) {

            $message = message("Cost Center cannot be deleted. Because, PRs are associated to it.", "error");
        } else {

            $response = $this->costCenterService->delete($costCenter);

            if ($response === true) {
                $message = message("CostCenter has been successfully deleted.");
            } else {
                $message = message("CostCenter has not deleted.", "error");
            }
        }
        session()->flash("message", $message);
        return redirect()->back();
    }
}
