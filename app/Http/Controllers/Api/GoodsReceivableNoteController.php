<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\GoodsReceivableNoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodsReceivableNoteController extends Controller
{
    protected $goodsReceivableNoteService;
    public function __construct(GoodsReceivableNoteService $goodsReceivableNoteService)
    {
        $this->goodsReceivableNoteService = $goodsReceivableNoteService;

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->goodsReceivableNoteService->store($request);
            DB::commit();
            $message = "Successfully Create GRN";
            return response()->json(['message' => $message], 201);

        } catch (\Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }

    }
}
