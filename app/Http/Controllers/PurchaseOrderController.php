<?php

namespace App\Http\Controllers;

use App\Helpers\ApprovalNotification;
use App\Models\PurchaseOrder;
use App\Services\CostCenterService;
use App\Services\EmployeeService;
use App\Services\PurchaseOrderService;
use App\Traits\MarkAsRead;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    use MarkAsRead;

    protected $purchaseOrderService;

    public function __construct()
    {
        $this->purchaseOrderService = new PurchaseOrderService();
//        $this->middleware('permission:purchase-order-list', ['only' => ['index']]);
        $this->middleware('permission:purchase-order-create', ['only' => ['create']]);
//        $this->middleware('permission:purchase-order-view', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $purchaseOrders = $this->purchaseOrderService->lists($data);
        $costCenter = (new CostCenterService())->getDropdownList();
        $employees = (new EmployeeService())->getDropdownList();
        return view('purchase-order.list', compact([
            'purchaseOrders',
            'costCenter',
            'employees',
            'request',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('purchase-order.create');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $purchaseOrder = PurchaseOrder::with(['approval' => function ($query) {
            $query->latest();
        },'purchaseOrderDetail'])->findOrFail($id);

        $approvalAccess = ApprovalNotification::approvalAccess($purchaseOrder->approval);
        $approvalAuthority = ApprovalNotification::approvalAuthority($purchaseOrder->approval);

        if(!$approvalAuthority && auth()->user()->type !='hq-admin' && auth()->user()->type !='admin'){
            abort(403, 'Access denied');
        }
        $this->markAsRead($request);
        $approvalId = ApprovalNotification::approvalId($purchaseOrder->approval);
        return view('purchase-order.view', compact(
            'purchaseOrder',
            'approvalAccess',
            'approvalId'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $user_id = auth()->user()->employee_id;
        $purchaseOrder_id = $purchaseOrder->id;
        return view('purchase-order.edit',compact([
            'user_id',
            'purchaseOrder_id',
        ]));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printPO($id)
    {
        $purchaseOrder = PurchaseOrder::query()
            ->with('costcenter.company',
                'purchaseOrderDetail',
                'vendor',
                'requisitions'
            )->find($id);
        $company = $purchaseOrder->costcenter->company->first();
        return view('purchase-order.print',compact(
        'purchaseOrder',
        'company'
        ));
    }

    public function withdraw(PurchaseOrder $purchaseOrder)
    {

        $response =  $this->purchaseOrderService->withdraw($purchaseOrder);
        if ($response === true) {
            $message = message("PO has been successfully withdraw.");
        } else {
            $message = message("PO has not withdraw.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();

    }
}
