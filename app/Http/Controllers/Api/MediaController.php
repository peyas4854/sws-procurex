<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function delete(Request $request)
    {

        $media = DB::table('media')->where('model_type',$request->model_type)
                                        ->where('uuid',$request->uuid)->delete();
        $message = "File delete Successfully";
        return response()->json(['message' => $message], 201);
    }
}
