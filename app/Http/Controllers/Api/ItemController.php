<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $ItemService;

    public function __construct()
    {
        $this->ItemService = new ItemService();
    }
    public function getItem($type)
    {

         $items = $this->ItemService->getItemBasedOnType($type);
//         dd($items);
         return ItemResource::collection($items);

    }
}
