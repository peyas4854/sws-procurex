<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionDetailsEditResource extends JsonResource
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
            'item_id'=>$this->item_id,
            'description'=>$this->description,
            'quantity'=>$this->quantity,
            'uom_id'=>$this->uom_id,
            'uom_name'=>$this->uom?$this->uom->name:'',
            'total_price'=>$this->price,
            'price'=>$this->price,
            'unit_price'=>$this->unit_price,
        ];
    }
}
