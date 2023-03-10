<?php

namespace App\Http\Controllers;
use App\Exports\ItemExport;
use App\Imports\ItemImport;
use App\Services\ItemImportService;
use Illuminate\Http\Request;
use File;
use Maatwebsite\Excel\Facades\Excel;
use Exception;


class ItemImportExportController extends Controller
{
    public function import()
    {
        return view("items.bulk-upload");
    }

    public function importStore(Request $request)
    {
        $fileName = File::extension($request->item_uploaded_file->getClientOriginalName());
        $extensions = array("xls", "xlsx");

        $fileExtension = $request->file('item_uploaded_file')->getClientOriginalExtension();

        if (!in_array($fileExtension, $extensions)) {
            $message = message("File is a '.$fileName.' file.!! Please upload a valid xls/xlsx file..!!", "error");
            session()->flash("message", $message);
            return redirect()->back();
        }
        $items = Excel::toArray(new ItemImport(), request()->file('item_uploaded_file'));
        try {
            $flag = 0;
            $processed = 0;
            foreach ($items[0] as $item) {

                $flag++;
                if (!isset($item['name'])) {
                    $incompleteRow[] = $item;
                    $request->session()->put('incompleteRow', $incompleteRow);
                    continue;
                }
                if (!isset($item['category'])) {
                    $incompleteRow[] = $item;
                    $request->session()->put('incompleteRow', $incompleteRow);
                    continue;
                }
                if (!isset($item['uom'])) {
                    $incompleteRow[] = $item;
                    $request->session()->put('incompleteRow', $incompleteRow);
                    continue;
                }
                if ($item['name'] != null) {
                    (new ItemImportService())->uploadItem($item);
                    $processed++;
                }
            }

            $message = message("<code>" . $processed . "</code> Items has been successfully processed from <code>" . $flag . "</code> records.");
            session()->flash("message", $message);
            return redirect('/items');
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
        return Excel::download(new ItemExport(), 'Item.xlsx');
    }
}
