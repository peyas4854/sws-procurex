<?php

namespace App\Services;

use App\Models\Company;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;


class CompanyService
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

        $query = Company::with('costCenters');

        // if(isset($data["search"])){

        //     $search_query = [
        //         "search" => $data["search"]
        //     ];

        //     $query->where(function($q) use($data){
        //         $q->orWhere("name", "LIKE", "%".$data["search"]."%");
        //     });
        // }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $companies = $query->paginate($item_per_page)->appends($search_query);
            $companies->pagination_summary = get_pagination_summary($companies);
        } else {
            $companies = $query->get();
        }

        return $companies;
    }

    public function updateOrCreate($data)
    {


        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update
            $company = Company::whereId($data["id"])->first();
            $company->updated_by = $user_id;

        } else {
            //create

            $company = new Company();
            $company->created_by = $user_id;
        }


        $company->name = $data['name'];


        if (isset($data['address'])) {
            $company->address = $data['address'];
        }


        if (isset($data['bin'])) {
            $company->bin = $data['bin'];
        }


        if (isset($data['phone_numbers'])) {
            $company->phone_numbers = $data['phone_numbers'];
        }


        if (isset($data['website'])) {
            $company->website = $data['website'];
        }


        if (isset($data['logo'])) {
//            dd($data['logo']);
            $logo = self::uploadImage($company->logo, $data['logo']);
            $company->logo = $logo;

        }

        return $company->save() ? $company : null;
    }

    public function uploadImage($request, $data)
    {
        if ($request != null) {
            if (file_exists($request)) {
                unlink($request);
            }
        }

        $uniqueFileName = uniqid() . time() . '.' . $data->getClientOriginalExtension();
        $directory = 'uploads/images/logo/';
        $imageUrl = $directory . $uniqueFileName;
        $data->move($directory, $uniqueFileName);
        return $imageUrl;
    }

    public function getbyId($id)
    {
            $data = DB::table('companies_cost_centers')->where('cost_center_id',$id)->first();
            if($data){
               return Company::query()->find($data->company_id);
            }

    }
}
