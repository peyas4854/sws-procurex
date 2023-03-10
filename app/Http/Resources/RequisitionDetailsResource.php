<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionDetailsResource extends JsonResource
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
            'unit_price'=>moneyFormatInTk($this->unit_price),
            'price'=>moneyFormatInTk($this->price),
            'quantity'=>$this->quantity,
            'uom'=>$this->uom->name,
            'item'=>new ItemResource($this->item),
            'brand'=>$this->brand,
            'description'=>$this->description,


        ];
    }
}
