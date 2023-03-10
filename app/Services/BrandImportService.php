<?php

namespace App\Services;

use App\Models\Brand;

class BrandImportService
{
    public function uploadItem($row)
    {
        Brand::query()->updateOrCreate(
            [
                "name" => $row["name"],
            ],
            [
                "name" => $row["name"],
                "created_by" => auth()->id(),
            ]
        );
    }
}
