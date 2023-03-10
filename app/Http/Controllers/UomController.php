<?php

namespace App\Http\Controllers;


use App\Http\Requests\Uom\SaveFormRequest;
use App\Http\Requests\Uom\UpdateFormRequest;
use App\Models\uom;
use App\Services\UomService;
use Illuminate\Http\Request;

class UomController extends Controller
{
    protected $uomService;

    public function __construct()
    {
        $this->uomService = new UomService();
        // Initiate Permission
        $this->middleware('permission:uom-list', ['only' => ['index']]);
        $this->middleware('permission:uom-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:uom-view', ['only' => ['show']]);
        $this->middleware('permission:uom-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:uom-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $uoms = $this->uomService->lists($data);

        $search = $request->search;

        return view("uoms.list", compact(["uoms", "search"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("uoms.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {
        $uom = $this->uomService->updateOrCreate($request);

        if (is_null($uom) === false) {
            $message = message("Uom has been successfully created.");
        } else {
            $message = message("Uom has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uom = $this->uomService->getById($id);
        return view("uoms.view", compact(["uom"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function edit(uom $uom)
    {
        return view("uoms.edit", compact(["uom"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, $id = null)
    {
        $validatedData = $request->validated();

        $uom = $this->uomService->updateOrCreate($validatedData);

        if (is_null($uom) === false) {
            $message = message("Uom has been successfully updated.");
        } else {
            $message = message("Uom has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function destroy(uom $uom)
    {
        if ($uom->items()->exists()) {

            $message = message("UoM cannot be deleted. Because, items are associated with it.", "error");

        } else {

            $response = $this->uomService->delete($uom);

            if ($response === true) {
                $message = message("Uom has been successfully deleted.");
            } else {
                $message = message("UoM has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
