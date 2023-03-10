<?php

namespace App\Http\Controllers;

use App\Exports\VendorExport;
use App\Imports\VendorImport;
use App\Models\Vendor;
use App\Services\VendorService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Vendors\SaveFormRequest;
use App\Http\Requests\Vendors\UpdateFormRequest;
use Exception;
use File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends Controller
{
    protected $vendorService;

    public function __construct()
    {
        $this->vendorService = new VendorService();
        // Initiate Permission
        $this->middleware('permission:vendor-list', ['only' => ['index']]);
        $this->middleware('permission:vendor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vendor-view', ['only' => ['show']]);
        $this->middleware('permission:vendor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $vendors = $this->vendorService->lists($data);

        $search = $request->search;
//        dd($vendors);

        return view("vendors.list", compact(["vendors", "search"]));
    }

    public function create()
    {
        return view("vendors.create");
    }

    public function edit($id)
    {
        $vendor = $this->vendorService->getById($id);
        return view("vendors.edit", compact(["vendor"]));
    }

    public function store(SaveFormRequest $request)
    {
        $validatedData = $request->all();
//        dd($validatedData);

        $vendor = $this->vendorService->updateOrCreate($validatedData);

        if (is_null($vendor) === false) {
            $message = message("Vendor has been successfully created.");
        } else {
            $message = message("Vendor has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function update(UpdateFormRequest $request)
    {
        $validatedData = $request->all();

        $vendor = $this->vendorService->updateOrCreate($validatedData);

        if (is_null($vendor) === false) {
            $message = message("Vendor has been successfully updated.");
        } else {
            $message = message("Vendor has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function show($id)
    {
        $vendor = $this->vendorService->getById($id);
        return view("vendors.view", compact(["vendor"]));
    }

    public function destroy(Vendor $vendor)
    {
        $response = $this->vendorService->delete($vendor);

        if ($response === true) {
            $message = message("Vendor has been successfully deleted.");
        } else {
            $message = message("Vendor has not deleted.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function import()
    {
        return view('vendors.upload.import');
    }

    public function uploadVendors(Request $request)
    {

        $fileName = File::extension($request->vendor_file->getClientOriginalName());
        $extensions = array("xls", "xlsx");

        $fileExtension = $request->file('vendor_file')->getClientOriginalExtension();

        if (!in_array($fileExtension, $extensions)) {
            $message = message("File is a '.$fileName.' file.!! Please upload a valid xls/xlsx file..!!", "error");
            session()->flash("message", $message);
            return redirect()->back();
        }

        try {
            $vendor_array = Excel::toArray(new VendorImport(), request()->file('vendor_file'));
            $flag = 0;
            $processed = 0;
            foreach ($vendor_array[0] as $item) {

                if (isset($item['name']) && $item['name'] != null) {
                    $this->vendorService->storeExcelRow($item);
                    $processed++;

                } else {
                    $incompleteRow[] = $item;
                    $request->session()->put('incompleteRow', $incompleteRow);
                }
                $flag++;

            }
            $message = message("<code>" . $processed . "</code> Vendors has been successfully processed from <code>" . $flag . "</code> records.");
            session()->flash("message", $message);
            return redirect('/vendors');

        } catch (Exception $ex) {
            $e = $ex->getMessage();
            return redirect()->back()->with("message", message("Something went wrong please check your excel file.$e.!!", "error"));

        }


    }

    public function reload(Request $request)
    {
        if ($request->session()->has('incompleteRow')) {
            $request->session()->forget('incompleteRow');
        }
        return redirect()->back();
    }

    public function exportVendors(Request $request)
    {
        return Excel::download(new VendorExport(), 'vendor.xlsx');
    }
}
