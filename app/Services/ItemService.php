<?php

namespace App\Services;

use App\Models\Item;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class ItemService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Item::query()->with(['brand' => function ($query) {
            $query->withCount('items');
        }, 'category' => function ($query) {
            $query->withCount('items');

        }, 'uom']);

        if (isset($data["search"])) {

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function ($q) use ($data) {
                $q->orWhere("name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("item_type", "LIKE", "%" . $data["search"] . "%");
                $q->orWhereHas('brand', function ($q) use ($data) {
                    $q->Where("name", "LIKE", "%" . $data["search"] . "%");
                });
                $q->orWhereHas('category', function ($q) use ($data) {
                    $q->Where("name", "LIKE", "%" . $data["search"] . "%");
                });
            });
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

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $item = Item::whereId($data["id"])->first();
            $item->updated_by = $user_id;

        } else {
            //create

            $item = new Item();
            $item->created_by = $user_id;
        }


        $item->name = $data['name'];


        if (isset($data['description'])) {
            $item->description = $data['description'];
        }


        if (isset($data['category_id'])) {
            $item->category_id = $data['category_id'];
        }


        if (isset($data['brand_id'])) {
            $item->brand_id = $data['brand_id'];
        }


        if (isset($data['uom_id'])) {
            $item->uom_id = $data['uom_id'];
        }


        if (isset($data['price'])) {
            $item->price = $data['price'];
        }


        if (isset($data['price_date'])) {
            $item->price_date = $data['price_date'];
        }


        if (isset($data['item_type'])) {
            $item->item_type = $data['item_type'];
        }


        $item->is_active = $data['is_active'] ?? 1;


        return $item->save() ? $item : null;
    }

    public function getById($id)
    {
        return Item::find($id);
    }

    public function delete($item)
    {
        return $item->delete();
    }

    public function getItemBasedOnType($type)
    {
        return Item::query()->where('item_type', $type)
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getItemsForPurchaseOrder()
    {
        return Item::query()->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function itemPriceUpdate($price, $id)
    {
       $item =  Item::query()->find($id)->update([
           'price'=>$price
       ]);

    }


}
