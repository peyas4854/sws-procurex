<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Services\DesignationService;
use Illuminate\Http\Request;
use App\Http\Requests\Designations\SaveFormRequest;
use App\Http\Requests\Designations\UpdateFormRequest;
use Gate;

class DesignationController extends Controller
{
    protected $designationService;

    public function __construct()
    {
        $this->designationService = new DesignationService();
        // Initiate Permission
        $this->middleware('permission:designation-list', ['only' => ['index']]);
        $this->middleware('permission:designation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:designation-view', ['only' => ['show']]);
        $this->middleware('permission:designation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:designation-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $designations = $this->designationService->lists($request->all());

        $search = $request->search;

        return view("designations.list", compact(["designations", "search"]));
    }

    public function create()
    {
        return view("designations.create");
    }

    public function edit($id)
    {
        $designation = $this->designationService->getById($id);

        return view("designations.edit", compact(["designation"]));
    }

    public function store(SaveFormRequest $request)
    {
        $validatedData = $request->validated();

        $designation = $this->designationService->updateOrCreate($validatedData);

        if (is_null($designation) === false) {
            $message = message("Designation has been successfully created.");
        } else {
            $message = message("Designation has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function update(UpdateFormRequest $request)
    {

        $validatedData = $request->all();

        $designation = $this->designationService->updateOrCreate($validatedData);

        if (is_null($designation) === false) {
            $message = message("Designation has been successfully updated.");
        } else {
            $message = message("Designation has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function show($id)
    {
        $designation = $this->designationService->getById($id);

        return view("designations.view", compact(["designation"]));
    }

    public function destroy(Designation $designation)
    {

        if ($designation->employees()->exists()) {

            $message = message("Designation cannot be deleted. Because, employees are assigned to it.", "error");

        } else {

            $response = $this->designationService->delete($designation);

            if ($response === true) {
                $message = message("Designation has been successfully deleted.");
            } else {
                $message = message("Designation has not deleted.", "error");
            }
        }
        session()->flash("message", $message);
        return redirect()->back();
    }
}
