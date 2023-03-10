<?php

namespace App\Imports;

use App\Models\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Vendor([
            "name" => $row["name"],
            "address" => $row["address"],
            "email" => $row["email"],
            "bin" => $row["bin"],
            "tin" => $row["tin"],
            "bank_account_name" => $row["bank_account_name"],
            "bank_account_number" => $row["bank_account_no"],
            "bank_name" => $row["bank_name"],
            "bank_branch" => $row["branch_name"],
            "bank_routing_number" => $row["bank_routing_no"],
            "created_by" => auth()->id(),
        ]);

    }



}
