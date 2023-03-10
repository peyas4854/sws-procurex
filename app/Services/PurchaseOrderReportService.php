<?php
namespace App\Services;

use App\Models\PurchaseOrderDetail;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;

class PurchaseOrderReportService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function report($data,$all=false){

        $order = $this->settingService->get("data_order", "desc") ?? "desc";
        $query = PurchaseOrderDetail::query()
            ->with('purchaseOrder.employee.department','item','grn');


        if(isset($data['item_type'])  && $data['item_type'] != ' ' ){
            $query->WhereHas('item', function ($q) use ($data) {
                $q->Where("item_type", '=',$data['item_type']);
            });
        }

        $query->orderBy('id', $order);


        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $reports = $query->paginate($item_per_page)->appends($data);
            $reports->pagination_summary = get_pagination_summary($reports);
        } else {
            $reports = $query->get();
        }
        if($all ==true){
            $reports = $query->get();
        }

        return $reports;

    }
}
