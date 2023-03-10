<?php

namespace App\Http\Controllers;

use App\Exports\BrandExport;
use App\Imports\BrandsImport;
use App\Services\BrandImportService;
use Illuminate\Http\Request;
use File;
use Maatwebsite\Excel\Facades\Excel;
use Exception;


class BrandImportExportController extends Controller
{
    /**
     * Show the upload form.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('brands.import');
    }

    public function store(Request $request)
    {
        $fileName = File::name($request->item_uploaded_file->getClientOriginalName());

        $extensions = array("xls", "xlsx");

        $fileExtension = $request->file('item_uploaded_file')->getClientOriginalExtension();

        if (!in_array($fileExtension, $extensions)) {
            $message = message("\"$fileName\" is a \"$fileExtension\" file!!! Please upload a valid xls/xlsx file..!!", "error");
            session()->flash("message", $message);
            return redirect()->back();
        }

        $file = $request->file('item_uploaded_file');

        $data = Excel::toArray(new BrandsImport, $file);

        try {
            $flag = 0;
            $processed = 0;
            foreach ($data[0] as $row) {
                $flag++;
                if (!isset($row['name'])) {
                    $incompleteRow[] = $row;
                    $request->session()->put('incompleteRow', $incompleteRow);
                    continue;
                }
                if ($row['name'] != null) {
                    (new BrandImportService)->uploadItem($row);
                    $processed++;
                }
            }

            $message = message("<code>" . $processed . "</code> Items has been successfully processed from <code>" . $flag . "</code> records.");
            session()->flash("message", $message);
            return redirect()->route('brands.index');
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

    public function export()
    {
        return Excel::download(new BrandExport(), 'Brand.xlsx');
    }
}
