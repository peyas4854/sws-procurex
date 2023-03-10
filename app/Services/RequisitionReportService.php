<?php

namespace App\Services;

use App\Models\RequisitionDetail;
use Carbon\Carbon;

class RequisitionReportService
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
        $query = RequisitionDetail::query()->with(['requisition.employee.department','item']);

        if(isset($data['item_type'])){
            $query->WhereHas('requisition', function ($q) use ($data) {
                $q->Where("item_type",$data['item_type']);
            });
        }

        if(isset($data['date_filter'])){
            $parts = explode(' - ' , $data['date_filter']);
            $date_from = Carbon::parse($parts[0]);
            $date_to = Carbon::parse($parts[1]);
            $query->WhereHas('requisition', function ($q) use ($data,$date_from,$date_to) {
                $q->whereBetween("application_date", [$date_from,$date_to]);
            });
        }

        $query->orderBy('id', $order);

        if($all){
           return $query->get();
        }

        if ($this->paginatedList === true) {
            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;
            $reports = $query->paginate($item_per_page)->appends($data);
            $reports->pagination_summary = get_pagination_summary($reports);
        } else {
            $reports = $query->get();
        }
        return $reports;
    }
}
