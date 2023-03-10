<?php

namespace App\Services;

use App\Models\GoodsReceivableNote;
use Illuminate\Support\Facades\DB;

class GoodsReceivableNoteService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {
        $search_query = [];
        $order = $this->settingService->get("data_order", "desc") ?? "desc";
        $query = GoodsReceivableNote::query()->with('purchaseDetail');
        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {
            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;
            $grns = $query->paginate($item_per_page)->appends($search_query);
            $grns->pagination_summary = get_pagination_summary($grns);
        } else {
            $grns = $query->get();
        }
        return $grns;

    }

    public function store($request)
    {
        $grnCode = self::grnCode();
        foreach (json_decode($request->items) as $item) {
            $goodsReceivableNote = GoodsReceivableNote::query()->create([
                'purchase_order_detail_id' => $item->id,
                'received_quantity' => $item->quantity,
                'comment' => $item->comment ?? null,
                'grn_code' => $grnCode,
                'created_by' => auth()->id(),
            ]);
            if (array_key_exists('files', $request->all())) {
                self::uploadFiles($goodsReceivableNote, $request);
            }
        }
    }

    public function uploadFiles($goodsReceivableNote, $request)
    {
        foreach ($request->files as $key => $file) {
            foreach ($file as $singlefile) {
                $goodsReceivableNote->addMedia($singlefile)
                    ->preservingOriginal()
                    ->toMediaCollection();
            }
        }
    }

    public function grnCode()
    {
        $code = 'GRN';
        $statement = DB::select("SHOW TABLE STATUS LIKE 'goods_receivable_notes'");
        $nextId = $statement[0]->Auto_increment;
        $initial_number = str_pad($nextId, 9, 0, STR_PAD_LEFT);
        return $code . $initial_number;
    }

}
