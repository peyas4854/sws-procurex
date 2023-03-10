<?php

namespace App\Services;

use App\Models\Designation;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class DesignationService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        // $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function getDropdownList()
    {
        return Designation::pluck('name', 'id');
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Designation::query()->with(['createdBy','updatedBy'])->withCount(['employees']);

        if (isset($data["search"])) {

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function ($q) use ($data) {
                $q->orWhere("name", "LIKE", "%" . $data["search"] . "%");
            });
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $designations = $query->paginate($item_per_page)->appends($search_query);
            $designations->pagination_summary = get_pagination_summary($designations);
        } else {
            $designations = $query->get();
        }

        return $designations;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $designation = Designation::whereId($data["id"])->first();
            $designation->updated_by = $user_id;

        } else {
            //create

            $designation = new Designation();
            $designation->created_by = $user_id;
        }


        $designation->name = $data['name'];


        if (isset($data['detail'])) {
            $designation->detail = $data['detail'];
        }


        return $designation->save() ? $designation : null;
    }

    public function getById($id)
    {
        return Designation::find($id);
    }

    public function delete($designation)
    {
        $designation = $designation->delete();
        return $designation;
    }

    public function getDesignation()
    {
        return Designation::query()->whereNull('deleted_at')
            ->select('id','name')
            ->get();
    }
}
