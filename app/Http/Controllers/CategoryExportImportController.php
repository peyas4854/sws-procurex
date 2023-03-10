<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use File;


class CategoryExportImportController extends Controller
{
    public function index()
    {
        return view('categories.import');
    }

    public function import(Request $request)
    {

        $fileName = File::name($request->category_uploaded_file->getClientOriginalName());

        $extensions = array("xls", "xlsx");

        $fileExtension = $request->file('category_uploaded_file')->getClientOriginalExtension();

        if (!in_array($fileExtension, $extensions)) {
            $message = message("\"$fileName\" is a \"$fileExtension\" file!!! Please upload a valid xls/xlsx file..!!", "error");
            session()->flash("message", $message);
            return redirect()->back();
        }
        $file = $request->file('category_uploaded_file');
        $data = Excel::toArray(new CategoryImport(), $file);


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
                    (new CategoryService())->uploadCategory($row);
                    $processed++;
                }
            }

            $message = message("<code>" . $processed . "</code> Category has been successfully processed from <code>" . $flag . "</code> records.");
            session()->flash("message", $message);
            return redirect()->route('categories.index');
        } catch (Exception $ex) {
            $e = $ex->getMessage();
            return redirect()->back()->with("message", message("Something went wrong please check your excel file.$e.!!", "error"));
        }
    }

    public function export()
    {
        return Excel::download(new CategoryExport(), 'Category.xlsx');
    }


}
