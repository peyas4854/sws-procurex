<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\CreateBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct()
    {
        // Initiate Permission
        $this->middleware('permission:brand-list', ['only' => ['index']]);
        $this->middleware('permission:brand-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:brand-view', ['only' => ['show']]);
        $this->middleware('permission:brand-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
        // Initiate Service
        $this->brandService = new BrandService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $brands = $this->brandService->lists($data);
        $search = $request->search;
        return view("brands.list", compact(["brands", "search"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("brands.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBrandRequest $request)
    {

        $brand = $this->brandService->updateOrCreate($request);

        if (is_null($brand) === false) {
            $message = message("Brand has been successfully created.");
        } else {
            $message = message("Brand has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $brand = $this->brandService->getById($id);
        return view("brands.view", compact(["brand"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view("brands.edit", compact(["brand"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id = null)
    {

        $brand = $this->brandService->updateOrCreate($request);
        if (is_null($brand) === false) {
            $message = message("Brand has been successfully updated.");
        } else {
            $message = message("Brand has not updated.", "error");
        }
        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if ($brand->items()->exists()) {

            $message = message("Brand cannot be deleted. Because, items are assigned to it.", "error");

        } else {

            $response = $this->brandService->delete($brand);
            if ($response === true) {
                $message = message("Brand has been successfully deleted.");
            } else {
                $message = message("Brand has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
