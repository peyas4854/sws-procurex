<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportItems implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Item([
            "category" => $row["category"],
            "item_name" => $row["item_name"],
            "brand" => $row["brand"],
            "description" => $row["description"],
            "product_type" => $row["product_type"]
        ]);
    }
}
