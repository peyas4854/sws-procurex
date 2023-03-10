<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrder\SaveFormRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\PurchaseOrderDetailResource;
use App\Http\Resources\PurchaseOrderEditResource;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Services\DepartmentService;
use App\Services\ItemService;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseOrderController extends Controller
{
    protected $purchaseOrderService;

    public function __construct()
    {
        $this->purchaseOrderService = new PurchaseOrderService();
    }

    public function purchaseOrderCreateInfo(): array
    {
        return $this->purchaseOrderService->creteInfo();
    }

    public function getItem()
    {
        $items = $this->purchaseOrderService->getItems();
        return ItemResource::collection($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_location' => 'required',
            'cost_center_id' => 'required',
        ]);
        $items = json_decode($request->purchaseOrderDetails);

        foreach ($items as $val) {
            if ($val->item_id == '') {
                return response()->json(['message' => 'Please select product'], 400);
            }
        }

        DB::beginTransaction();
        try {
            $this->purchaseOrderService->store($request);
            DB::commit();
            $message = "Successfully Create Purchase Order";
            return response()->json(['message' => $message], 201);

        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }

    }

    public function getApprovedPurchaseOrder()
    {
        return $this->purchaseOrderService->getApprovedPR();
    }
    public function getPurchaseOrderDetail($id){

        $purchaseOrderDetail = PurchaseOrderDetail::query()->where('purchase_order_id',$id)->get();
        return PurchaseOrderDetailResource::collection($purchaseOrderDetail);
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        return new PurchaseOrderEditResource($purchaseOrder);
    }

}
