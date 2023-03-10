<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\uom;

class ItemImportService
{


    public function uploadItem($row)
    {

        $categoryId = $row['category'] ? self::categoryId($row['category']) : null;
        $brandId = $row['brand'] ? self::brandId($row['brand']) : null;
        $uomId = $row['uom'] ? self::uomId($row['uom']) : null;
        Item::query()->updateOrCreate(
            [
                "name" => $row["name"],
                "category_id" => $categoryId
            ],
            [
                "name" => $row["name"],
                "description" => $row["description"] ?? null,
                "category_id" => $categoryId,
                "brand_id" => $brandId,
                "uom_id" => $uomId,
                "price" => $row["price"] ?? null,
                "price_date" => $row["price_date"] ?? null,
                "item_type" => $row["product_type"] == 'IT Item' ? 'it' : 'admin',
                "is_active" => $row["active"] == 'yes' ? 1 : 0,
                "created_by" => auth()->id(),
            ]
        );

    }

    public function categoryId($category)
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

    public function brandId($brand)
    {
        $brand = Brand::query()->firstOrCreate(
            ['name' => $brand],
            [
                'name' => $brand,
                'created_by' => auth()->id()
            ],
        );
        return $brand->id;
    }

    public function uomId($uom)
    {
        $uom = uom::query()->firstOrCreate(
            ['name' => $uom],
            [
                'name' => $uom,
                'created_by' => auth()->id()
            ],
        );
        return $uom->id;
    }
}
