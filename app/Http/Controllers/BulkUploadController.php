<?php

namespace App\Http\Controllers;

use  File;
use Illuminate\Support\Str;
use App\Imports\ImportItems;
use Illuminate\Http\Request;
use App\Services\ItemService;

use App\Services\BrandService;
use App\Services\CategoryService;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{

    protected $categoryService, $brandService, $itemService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->itemService = new ItemService();
    }

    
    public function itemUpload()
    {
        //$this->authorize("bulkUpload", EmployeeAttendance::class);

        return view("items.bulk-upload");
    }    

    public function uploadedItemSave (Request $request)
    {
        //$this->authorize("create", EmployeeAttendance::class);

        //$item = $request->validated();

        $fileName = File::extension($request->uploaded_file->getClientOriginalName());

        $extensions = array("xls","xlsx");

        $fileExtension = $request->file('uploaded_file')->getClientOriginalExtension();

        if(!in_array($fileExtension,$extensions)){            
            $message = message("File is a '.$fileName.' file.!! Please upload a valid xls/xlsx file..!!", "error");            
            session()->flash("message", $message);       
            return redirect()->back();
        }

        $items_array = Excel::toArray(new ImportItems(), $request->file("uploaded_file"));
        
        //dd( $items_array );
        $category_array = $this->categoryService->allCategoryArray();
        $brand_array = $this->brandService->allBrandArray();
        $flag = 0;
        $processed = 0;
        $batch = uniqid();

        foreach ($items_array[0] as $item) 
        {
            
            /*$itemId = $this->employeeService->existingItem($item['name']);

            if(is_null($employeeId)){

                $existingEmployee[] = $item['employee_code'];

                $request->session()->put('fakeEmployee', $existingEmployee);

            }else{*/

                if(isset($item['item_name']))
                {
                
                    $data['name'] = $item['item_name'];
                    $data['description'] =  $item['description'] ? Str::limit($item['description'], $limit = 240, $end = '...') : null ;
                    $data['category_id'] = $item["category"] ? $category_array[$item["category"]]: null;
                    $data['brand_id'] = $item["brand"] ? $brand_array[$item["brand"]] : null;
                    $data['uom_id'] = $item["uom"] ?? 1;
                    $data['price'] = $item["price"] ?? null;
                    $data['price_date'] = $item["price_date"] ?? null;
                    $data['item_type'] = $item["product_type"]? strtolower($item["product_type"]) : null;
                    $data['is_active'] = $item["is_active"] ?? 1;
                    // $data['total_working_days'] = $item['total_working_days'];
                    // $data['days_worked'] = $item['days_worked'];                              
                    // $data['batch'] = $batch;
                    $this->itemService->updateOrCreate($data);
                    $processed ++;
                
                }else{
                    $incompleteRow[] = $item;
                    $request->session()->put('incompleteRow', $incompleteRow);
                }
                    
                $flag++;
            //}

        }
        
        $message = message( "<code>".$processed."</code> Employee Attendance(s) has been successfully processed from <code>".$flag."</code> records.");       

        session()->flash("message", $message);

        return redirect('/items');
    }
}
