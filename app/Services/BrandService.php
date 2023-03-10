<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    protected $settingService;
    public $paginatedList = true;

    public function __construct()
    {
        $this->settingService = new SettingService();
    }
    public function getDropdownList()
    {
        return Brand::pluck('name', 'id');
    }
    public function lists($data = null)
    {
        $search_query = [];
        $order = $this->settingService->get("data_order", "desc") ?? "desc";
        $query = Brand::query()->withCount(['items']);
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

            $brands = $query->paginate($item_per_page)->appends($search_query);
            $brands->pagination_summary = get_pagination_summary($brands);
        } else {
            $brands = $query->get();
        }
        return $brands;
    }
    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;
        if (!empty($data["id"])) {
            // update
            $brand = Brand::whereId($data["id"])->first();
            $brand->updated_by = $user_id;
        } else {
            //create
            $brand = new Brand();
            $brand->created_by = $user_id;
        }

        $brand->name = $data['name'];
        return $brand->save() ? $brand : null;
    }

    public function getById($id)
    {
        return Brand::find($id);
    }

    public function delete($brand)
    {
        return $brand->delete();
    }
    public function allBrandArray()
    {
        $brands = Brand::select(array("id","name"))->get();
        $brand_array = array();
        foreach ($brands as $brand){
            $brand_array [$brand->name] = $brand->id;
        }
        return $brand_array;
    }
}
