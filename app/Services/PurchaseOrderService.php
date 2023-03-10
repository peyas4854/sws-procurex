<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\CsDetail;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\RequisitionDetail;
use Carbon\Carbon;

class PurchaseOrderService
{
    protected $errorNotifier;
    protected $settingService;
    protected $dateFormat;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
        $this->dateFormat = $this->settingService->get("date_format") ?? "Y-m-d";
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        if (auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin') {
            $query = PurchaseOrder::query()->with(['employee', 'costcenter','requisitions']);
        } else {
            $perchase_order_ids = PurchaseOrder::query()->where('created_by', auth()->id())->pluck('id')->unique()->toArray();
            $approval_ids = array();
            if (auth()->user()->employee) {
                $approval_ids = Approval::query()->where('approvalable_type', 'App\Models\PurchaseOrder')
                    ->where('employee_id', auth()->user()->employee->id)
                    ->pluck('approvalable_id')->unique()->toArray();
            }
            $ids = (array_merge($perchase_order_ids, $approval_ids));
            $query = PurchaseOrder::query()->with(['costcenter', 'employee','requisitions'])->whereIn('id', array_unique($ids));
        }

        if (isset($data["search"])) {
            $search_query = [
                "search" => $data["search"]
            ];
            $query->where(function ($q) use ($data) {
                $q->orWhere("po_code", "LIKE", "%" . $data["search"] . "%");
            });

        }
        if (isset($data["cost_center_id"])) {
            $search_query = [
                "cost_center_id" => $data["cost_center_id"]
            ];
            $query->Where("cost_center_id", $data["cost_center_id"]);

        }
        if (isset($data["status"])) {
            $search_query = [
                "status" => $data["status"]
            ];
            $query->Where("status", $data["status"]);
        }
        if (isset($data["employee_id"])) {
            $search_query = [
                "employee_id" => $data["employee_id"]
            ];
            $query->Where("employee_id", $data["employee_id"]);
        }
        if(isset($data['date_filter'])){
            $parts = explode(' - ' , $data['date_filter']);
            $date_from = Carbon::parse($parts[0]);
            $date_to = Carbon::parse($parts[1]);
            $query->whereBetween("delivery_date",[$date_from,$date_to]);
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {
            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;
            $items = $query->paginate($item_per_page)->appends($search_query);
            $items->pagination_summary = get_pagination_summary($items);
        } else {
            $items = $query->get();
        }

        return $items;
    }

    public function creteInfo()
    {
        $info = [];
        $info['dateFormate'] = dateFormate();
        $info['budgetInfo'] = budgetInfo();
        $info['vatList'] = self::vatList();
        $info['procurementType'] = procurementType();
        $info['costCenterList'] = (new CostCenterService())->getCostCenter();
        $info['vendorList'] = (new VendorService())->getDropDown();
        $info['uomList'] = (new UomService())->getUom();
        $info['csDetailList'] = (new CsDetailService())->getCSDropDown();
        $info['requisitionList'] = (new RequisitionService())->getRequisitionDropDown();
        $info['application_date'] = Carbon::today()->format($this->dateFormat);
        $info['employee_name'] = auth()->user()->employee->full_name;
        $info['employee_id'] = auth()->user()->employee->code;
        return $info;
    }

    public function getItems()
    {
        return (new ItemService())->getItemsForPurchaseOrder();
    }

    public function vatlist()
    {
        return config("constants.vat_list");
    }

    public function store($request)
    {

        $purchaseOrder = self::updateOrCreate($request);
        self::storePurchaseDetails($request, $purchaseOrder->id);
        self::purchaseOrderRelationStore($request, $purchaseOrder);
        (new PurchaseOrderApprovalService())->createApproval($purchaseOrder);
        (new PurchaseOrderApprovalService())->triggerNotification($purchaseOrder,'bu_head');
        return $purchaseOrder ? $purchaseOrder : null;

    }

    public function updateOrCreate($data)
    {

        $user_id = auth()->user()->id;
        $employee_id = auth()->user()->employee->id;

        if (!empty($data["id"])) {
            // update
            $purchaseOrder = PurchaseOrder::whereId($data["id"])->first();
            $purchaseOrder->updated_by = $user_id;
            $purchaseOrder->status = 'pending';

        } else {
            //create
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->created_by = $user_id;
            $purchaseOrder->employee_id = $employee_id;
            $purchaseOrder->po_code = self::poCode();
            $purchaseOrder->application_date = Carbon::now();
        }

        if (isset($data['vendor_id'])) {
            $purchaseOrder->vendor_id = $data['vendor_id'];
        }
        if (isset($data['delivery_location'])) {
            $purchaseOrder->delivery_location = $data['delivery_location'];
        }
        if (isset($data['delivery_date'])) {
            $delivery_date = self::deliveryDate($data['delivery_date']);
            $purchaseOrder->delivery_date = $delivery_date;
        }
        if (isset($data['cost_center_id'])) {
            $purchaseOrder->cost_center_id = $data['cost_center_id'];
        }
        if (isset($data['procurement_type'])) {
            $purchaseOrder->procurement_type = $data['procurement_type'];
        }
        if (isset($data['budget_info'])) {
            $purchaseOrder->budget_info = $data['budget_info'];
        }

        if (isset($data['total_price_without_vat'])) {
            $purchaseOrder->total_price_without_vat = $data['total_price_without_vat'];
        }
        if (isset($data['total_price_with_vat'])) {
            $purchaseOrder->total_price_with_vat = $data['total_price_with_vat'];
        }
        if (isset($data['terms_and_condition'])) {
            $purchaseOrder->terms_and_condition = $data['terms_and_condition'];
        }
        return $purchaseOrder->save() ? $purchaseOrder : null;
    }

    public function deliveryDate($delivery_date)
    {
        if ($delivery_date != 'null' && !is_null($delivery_date)) {
            return Carbon::parse($delivery_date)->format($this->dateFormat);
        } else {
            return null;
        }
    }

    public function poCode()
    {
        $code = 'PO';
        $query = PurchaseOrder::query()->select('po_code')
            ->where('po_code', 'LIKE', '%' . $code . '%')
            ->withTrashed()
            ->latest()->first();

        $initial_number = str_pad(1, 9, 0, STR_PAD_LEFT);
        if (is_null($query)) {
            $poCode = $code . $initial_number;
        } else {
            $value = explode('PO', $query->po_code);
            $number = $value[1] + 1;
            $next_number = str_pad($number, 9, 0, STR_PAD_LEFT);
            $poCode = $code . $next_number;

        }
        return $poCode;
    }

    public function storePurchaseDetails($request, $purchaseOrderId)
    {
        if ($request->revert_mode === "true") {

            PurchaseOrderDetail::query()->where('purchase_order_id', $purchaseOrderId)->delete();
        }
        foreach (json_decode($request->purchaseOrderDetails) as $item) {

            $purchaseOrderDetail = PurchaseOrderDetail::query()->Create(
                [
                    'purchase_order_id' => $purchaseOrderId,
                    'description' => $item->description,
                    'item_id' => $item->item_id,
                    'uom_id' => $item->uom_id,
                    'category_id' => $item->category_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price_without_vat' => $item->total_price_without_vat,
                    'vat' => $item->vat,
                    'vat_amount' => $item->vat_amount,
                    'total_price_with_vat' => $item->total_price_with_vat,
                ]);
            if (isset($item->requisition_detail_id)) {
                $purchaseOrderDetail->requisitionsDetail()->sync($item->requisition_detail_id);
            }
        }
    }

    public function purchaseOrderRelationStore($request, $purchaseOrder)
    {

        if ($request->cs_detail != null) {
            $cs_detail_id = explode(',', $request->cs_detail);
            $purchaseOrder->csDetails()->sync($cs_detail_id);
        }
        if ($request->requisition != null) {
            $requisition_id = explode(',', $request->requisition);
            $purchaseOrder->requisitions()->sync($requisition_id);
        }
    }

    public function getApprovedPR()
    {
        return PurchaseOrder::query()->where('status','approved')
            ->select('id','po_code','status')
            ->get();
    }

    public function withdraw($purchaseOrder)
    {
        return $purchaseOrder->update([
            'status'=>'draft',
        ]);

    }
}
