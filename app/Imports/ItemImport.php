<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Item([
            "name" => $row["name"],
            "description" => $row["description"],
            "category" => $row["category"],
            "brand" => $row["brand"],
            "uom" => $row["uom"],
            "price_date" => $row["price_date"],
            "item_type" => $row["product_type"],
            "active" => $row["active"],
        ]);
    }
}
