<?php

namespace App\Http\Controllers;

use App\Services\CsDetailApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CsDetailApprovalController extends Controller
{
    protected $csDetailApprovalService;

    public function __construct(CsDetailApprovalService $csDetailApprovalService)
    {
        $this->csDetailApprovalService = $csDetailApprovalService;
    }

    public function statusChange(Request $request)
    {

        DB::beginTransaction();
        try {
            $this->csDetailApprovalService->statusChange($request);
            DB::commit();
            $message = message("Your response has been recorded successfully");
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = message("Something went wrong. See details" . $e,"error");
        }
        session()->flash("message", $message);
        return redirect('cs-details');

    }
    public function masterUserStatusChange(Request $request)
    {

        DB::beginTransaction();
        try {
            $this->csDetailApprovalService->masterUserStatusChange($request);
            DB::commit();
            $message = message("Your response has been recorded successfully");
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = message("Something went wrong. See details" . $e,"error");
        }
        session()->flash("message", $message);
        return redirect('cs-details');

    }
}
