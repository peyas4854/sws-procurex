<?php

namespace App\Http\Controllers;

use App\Http\Requests\Items\SaveFormRequest;
use App\Http\Requests\Items\UpdateFormRequest;
use App\Models\Item;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ItemService;
use App\Services\UomService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $ItemService;

    public function __construct()
    {
        $this->ItemService = new ItemService();
        // Initiate Permission
        $this->middleware('permission:item-list', ['only' => ['index']]);
        $this->middleware('permission:item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:item-view', ['only' => ['show']]);
        $this->middleware('permission:item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:item-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $items = $this->ItemService->lists($data);
        $search = $request->search;

        return view("items.list", compact(["items", "search"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = (new CategoryService())->getDropdownList();
        $brand = (new BrandService())->getDropdownList();
        $uom = (new UomService())->getDropdownList();

        return view("items.create", compact('category', 'brand', 'uom'));
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

        $item = $this->ItemService->updateOrCreate($validatedData);

        if (is_null($item) === false) {
            $message = message("Item has been successfully created.");
        } else {
            $message = message("Item has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $item = $this->ItemService->getById($id);
        return view("items.view", compact(["item"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $category = (new CategoryService())->getDropdownList();
        $brand = (new BrandService())->getDropdownList();
        $uom = (new UomService())->getDropdownList();

        return view("items.edit", compact("item", 'category', 'brand', 'uom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, $id = null)
    {
        $validatedData = $request->validated();

        $item = $this->ItemService->updateOrCreate($validatedData);

        if (is_null($item) === false) {
            $message = message("Item has been successfully updated.");
        } else {
            $message = message("Item has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if ($item->requisitions()->exists()) {

            $message = message("Item cannot be deleted. Because, item is used in PR.", "error");

        } else {

            $response = $this->ItemService->delete($item);

            if ($response === true) {
                $message = message("Item has been successfully deleted.");
            } else {
                $message = message("Item has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
