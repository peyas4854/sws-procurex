<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\SaveFormRequest;
use App\Http\Requests\Company\UpdateFormRequest;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\CostCenterService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{
    protected $companyService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
        $this->middleware('permission:company-list', ['only' => ['index']]);
        $this->middleware('permission:company-create', ['only' => ['create','store']]);
        $this->middleware('permission:company-view', ['only' => ['show']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $companies = $this->companyService->lists($data);

        $search = $request->search;

        return view("companies.list", compact(["companies", "search"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allCostCenters = (new CostCenterService())->getDropdownList();
        $companies_cost_centers = DB::table('companies_cost_centers')->pluck('cost_center_id')->toArray();

        return view("companies.create",compact('allCostCenters','companies_cost_centers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {

        $validatedData = $request->validated();

        $company = $this->companyService->updateOrCreate($validatedData);

        if($request->cost_centers){
            $company->costCenters()->sync($request->cost_centers);
        }

        if(is_null($company) === false){
            $message = message("Company has been successfully created.");
        }else{
            $message = message("Company has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect('companies');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allCostCenters = (new CostCenterService())->getDropdownList();
        $companies_cost_centers = DB::table('companies_cost_centers')->pluck('cost_center_id')->toArray();

        $company = Company::query()->with('costCenters:id,name')->find($id);
        $data = $company->costCenters->pluck('name','id')->toArray();
        $checkSelected =$company->costCenters->pluck('id')->toArray();

        $company->costCenters = $data;


        return view("companies.edit",compact('company',
            'allCostCenters',
            'companies_cost_centers',
            'checkSelected'
        ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request)
    {

        $validatedData = $request->validated();
        $company = $this->companyService->updateOrCreate($validatedData);

        if($request->cost_centers){
            $company->costCenters()->sync($request->cost_centers);
        }else{
            $company->costCenters()->sync(null);
        }

        if(is_null($company) === false){
            $message = message("Company has been successfully updated.");
        }else{
            $message = message("Company has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect('companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {

        if ($company->costCenters()->exists()) {
            $message = message("Company cannot be deleted. Because, company are assigned to cost center.", "error");
        } else {
            $response = $company->delete();
            if ($response === true) {
                $message = message("Company has been successfully deleted.");
            } else {
                $message = message("Company has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();

    }

    public function selectConstCenter(Request $request)
    {
        return (new CostCenterService())->selectCostCenter($request->q);
    }
}
