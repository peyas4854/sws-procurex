<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'uom'=>$this->uom ? $this->uom->name: " ",
            'uom_id'=>$this->uom_id,
            'description'=>$this->description,
            'brand'=>$this->brand ? $this->brand->name : '',
            'price'=>$this->price,
            'price_date'=>$this->price_date,
            'item_type'=>$this->item_type,
            'category_id'=>$this->category_id,
            'category'=>$this->category ? $this->category->name:'',
        ];
    }
}
