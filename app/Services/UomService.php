<?php

namespace App\Services;

use App\Models\uom;

use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class UomService
{
//    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
//        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }
    public function getDropdownList()
    {
        return uom::pluck('name', 'id');
    }
    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Uom::query();

         if(isset($data["search"])){

             $search_query = [
                 "search" => $data["search"]
             ];

             $query->where(function($q) use($data){
                 $q->orWhere("name", "LIKE", "%".$data["search"]."%");
             });
         }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $uoms = $query->paginate($item_per_page)->appends($search_query);
            $uoms->pagination_summary = get_pagination_summary($uoms);
        } else {
            $uoms = $query->get();
        }

        return $uoms;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if(!empty($data["id"])){
            // update

            $uom = Uom::whereId($data["id"])->first();
            $uom->updated_by = $user_id;

        }else{
            //create

            $uom = new Uom();
            $uom->created_by = $user_id;
        }


        $uom->name = $data['name'];


        if(isset($data['description'])){
            $uom->description = $data['description'];
        }


        return $uom->save() ? $uom : null;
    }

    public function getById($id)
    {
        return Uom::find($id);
    }

    public function delete($uom)
    {
        return $uom->delete();
    }
    public function getUom(){
        return Uom::query()->select('id','name')->get();
    }
}
