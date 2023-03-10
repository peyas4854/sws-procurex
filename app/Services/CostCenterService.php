<?php

namespace App\Services;

use App\Models\CostCenter;
use App\Models\CostCenterFinance;
use App\Models\CostCenterHead;
use Illuminate\Support\Arr;

class CostCenterService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function getDropdownList()
    {

        return CostCenter::pluck('name', 'id');
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        // $query = CostCenter::query();
        $query = CostCenter::query()->with(['buHeads','financeApprover'])->withCount(['employees']);

        if (isset($data["search"])) {

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function ($q) use ($data) {
                $q->orWhere("name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("cost_center_code", "LIKE", "%" . $data["search"] . "%");
                /** Searching relation for bu heads */
                $q->orWhereHas('buHeads', function ($query) use ($data) {
                    $query->Where("first_name", "LIKE", "%" . $data["search"] . "%");
                });
                $q->orWhereHas('buHeads', function ($query) use ($data) {
                    $query->Where("middle_name", "LIKE", "%" . $data["search"] . "%");
                });
                $q->orWhereHas('buHeads', function ($query) use ($data) {
                    $query->Where("last_name", "LIKE", "%" . $data["search"] . "%");
                });
            });
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {
            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;
            $cost_centers = $query->paginate($item_per_page)->appends($search_query);
            $cost_centers->pagination_summary = get_pagination_summary($cost_centers);
        } else {
            $cost_centers = $query->get();
        }

        return $cost_centers;
    }

    public function updateOrCreate($data)
    {

        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $cost_center = CostCenter::whereId($data["id"])->first();
            $cost_center->updated_by = $user_id;
        } else {
            //create

            $cost_center = new CostCenter();
            $cost_center->created_by = $user_id;
        }


        $cost_center->name = $data['name'];


        if (isset($data['cost_center_code'])) {
            $cost_center->cost_center_code = $data['cost_center_code'];
        }


        if (isset($data['description'])) {
            $cost_center->description = $data['description'];
        }

        $cost_center->save();

        if (isset($data['buHeads'])) {
            $cost_center->buHeads()->sync($data['buHeads']);
        }else{
            $cost_center->buHeads()->detach();
        }

        if (isset($data['finance_ids'])) {
            $cost_center->financeApprover()->sync($data['finance_ids']);
        }else{
            $cost_center->financeApprover()->detach();
        }

        return $cost_center;
    }

    public function getById($id)
    {
        return CostCenter::find($id);
    }

    public function delete($cost_center)
    {
        $cost_center->buHeads()->detach();
        return $cost_center->delete();
    }

    public function getCostCenter()
    {
        return CostCenter::query()->whereNull('deleted_at')
            ->select('id', 'name')
            ->get();
    }

    public function getMembers($cost_center_id)
    {
        return CostCenterHead::query()
            ->where('cost_center_id', $cost_center_id)
            ->pluck('employee_id')->toArray();
    }

    public function financeApproval($cost_center_id)
    {
        return CostCenterFinance::query()
            ->where('cost_center_id', $cost_center_id)
            ->pluck('employee_id')->toArray();

    }

    public function selectCostCenter($data = null)
    {
        if ($data !== null ) {
            $query = CostCenter::select(["id", 'name']);

            $query->where(function ($q) use ($data) {
                $q->orWhere("name", "LIKE", "%" . $data . "%");
            });
            return $query->get('name', 'id')->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                ];
            });
        }
    }


}
