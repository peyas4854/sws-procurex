<?php

namespace App\Services;

use App\Models\Category;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class CategoryService
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
        return Category::pluck('name', 'id');
    }

    public function getParentsList()
    {
        return Category::whereParentCategoryId(null)->pluck('name','id');
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Category::query()->withCount(['items']);

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

            $categories = $query->paginate($item_per_page)->appends($search_query);
            $categories->pagination_summary = get_pagination_summary($categories);
        } else {
            $categories = $query->get();
        }

        return $categories;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $category = Category::whereId($data["id"])->first();
            $category->updated_by = $user_id;

        } else {
            //create

            $category = new Category();
            $category->created_by = $user_id;
        }


        $category->name = $data['name'];


        if (isset($data['description'])) {
            $category->description = $data['description'];
        }


        if (isset($data['category_code'])) {
            $category->category_code = $data['category_code'];
        }


        if (isset($data['parent_category_id'])) {
            $category->parent_category_id = $data['parent_category_id'];
        }


        return $category->save() ? $category : null;
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function delete($category)
    {
        $category = $category->delete();
        return $category;
    }
    public function allCategoryArray()
    {
        $categories = Category::select(array("id","name"))->get();
        $category_array = array();
        foreach ($categories as $category){
            $category_array [$category->name] = $category->id;
        }
        return $category_array;
    }

    public function uploadCategory($row)
    {

        $parentCategoryId = $row['parent_category'] ? self::parentCategory($row['parent_category']) : null;

        Category::query()->updateOrCreate(
            [
                "name" => $row["name"],
            ],
            [
                "name" => $row["name"],
                "description" => $row["description"] ?? null,
                "category_code" => $row['category_code']?? null,
                "parent_category_id" => $parentCategoryId,
                "created_by" => auth()->id(),

            ]
        );

    }

    public function parentCategory($category)
    {
        $category = Category::query()->firstOrCreate(
            ['name' => $category],
            [
                'name' => $category,
                'created_by' => auth()->id()
            ],
        );
        return $category->id;
    }
}
