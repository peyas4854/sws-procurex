<?php

namespace App\Services;
use App\Models\Vendor;

class VendorService
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

        $query = Vendor::query();

        if (isset($data["search"])) {

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function ($q) use ($data) {
                $q->orWhere("name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("vendor_code", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("office_email", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("office_phone", "LIKE", "%" . $data["search"] . "%");
            });
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $vendors = $query->paginate($item_per_page)->appends($search_query);
            $vendors->pagination_summary = get_pagination_summary($vendors);
        } else {
            $vendors = $query->get();
        }

        return $vendors;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $vendor = Vendor::whereId($data["id"])->first();
            $vendor->updated_by = $user_id;

        } else {
            //create

            $vendor = new Vendor();
            $vendor->created_by = $user_id;
        }


        if (isset($data['vendor_code'])) {
            $vendor->vendor_code = $data['vendor_code'];
        }


        $vendor->name = $data['name'];


        if (isset($data['address'])) {
            $vendor->address = $data['address'];
        }


        if (isset($data['office_phone'])) {
            $vendor->office_phone = $data['office_phone'];
        }


        if (isset($data['office_email'])) {
            $vendor->office_email = $data['office_email'];
        }


        if (isset($data['bin'])) {
            $vendor->bin = $data['bin'];
        }


        if (isset($data['tin'])) {
            $vendor->tin = $data['tin'];
        }


        if (isset($data['trade_license'])) {
            $vendor->trade_license = $data['trade_license'];
        }


        if (isset($data['bank_account_name'])) {
            $vendor->bank_account_name = $data['bank_account_name'];
        }


        if (isset($data['bank_account_number'])) {
            $vendor->bank_account_number = $data['bank_account_number'];
        }


        if (isset($data['bank_routing_number'])) {
            $vendor->bank_routing_number = $data['bank_routing_number'];
        }


        if (isset($data['bank_name'])) {
            $vendor->bank_name = $data['bank_name'];
        }


        if (isset($data['bank_branch'])) {
            $vendor->bank_branch = $data['bank_branch'];
        }
        if (isset($data['status'])) {
            $vendor->bank_branch = $data['status'];
        }


        //$vendor->status = $data['status'];

        return $vendor->save() ? $vendor : null;
    }

    public function getById($id)
    {
        return Vendor::find($id);
    }

    public function delete($vendor)
    {
        return$vendor->delete();
    }

    public function getDropDown()
    {
        return Vendor::query()->whereNull('deleted_at')
            ->select('id', 'name')
            ->get();
    }

    public function storeExcelRow($row)
    {
        $vendor = Vendor::query()->updateOrCreate(
            ["name" => $row["name"]],
            [
                "name" => $row["name"],
                "address" => $row["address"] ?? null,
                "bin" => $row["bin"] ?? null,
                "tin" => $row["tin"] ?? null,
                "bank_account_name" => $row["bank_account_name"] ?? null,
                "bank_account_number" => $row["bank_account_number"] ?? null,
                "bank_name" => $row["bank_name"] ?? null,
                "bank_branch" => $row["bank_branch"] ?? null,
                "bank_routing_number" => $row["bank_routing_number"] ?? null,
                "created_by" => auth()->id(),
            ]
        );
        self::storeContract($vendor, $row);
    }

    public function storeContract($vendor, $row)
    {
        $vendor->contacts()->updateOrCreate(
            ["contact_person" => $row["contact_person"]],
            [
                'contact_person' => $row["contact_person"],
                'contact_email' => $row["contact_email"],
                'contact_phone' => $row["contact_phone"],
            ]
        );
    }

}
