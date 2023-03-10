<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait MarkAsRead
{
    public function markAsRead($request)
    {
        if(!empty($request->ref)){
            DB::table("notifications")->whereId($request->ref)->update(["read_at" => now()]);
        }
    }
}
