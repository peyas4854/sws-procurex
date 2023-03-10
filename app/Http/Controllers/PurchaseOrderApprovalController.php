<?php

namespace App\Http\Controllers;

use App\Services\PurchaseOrderApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseOrderApprovalController extends Controller
{

    protected $purchaseOrderApproval;

    public function __construct(PurchaseOrderApprovalService $purchaseOrderApproval)
    {
        $this->purchaseOrderApproval = $purchaseOrderApproval;
    }
    public function statusChange(Request $request){

        DB::beginTransaction();
        try {
            $this->purchaseOrderApproval->statusCheck($request);
            DB::commit();
            $message = message("Your response has been recorded successfully");
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = message("Something went wrong. See details" . $e,"error");
        }
        session()->flash("message", $message);
        return redirect('purchase-orders');
    }

    public function masterUserStatusChange(Request $request){

        DB::beginTransaction();
        try {
            $this->purchaseOrderApproval->masterUserStatusChange($request);
            DB::commit();
            $message = message("Your response has been recorded successfully");
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = message("Something went wrong. See details" . $e,"error");
        }
        session()->flash("message", $message);
        return redirect('purchase-orders');
    }


}
