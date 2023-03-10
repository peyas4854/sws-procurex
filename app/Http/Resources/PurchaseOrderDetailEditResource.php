<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderDetailEditResource extends JsonResource
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
            'purchase_order_id'=>$this->purchase_order_id,
            'item_id'=>$this->item_id,
            'description'=>$this->description,
            'item_name'=>$this->item->name,
            'category'=>$this->category ? $this->category->name:'',
            'category_id'=>$this->category_id,
            'uom'=>$this->uom ? $this->uom->name:'',
            'quantity'=>$this->$this->quantity,
            'unit_price'=>$this->unit_price,
            'total_price_without_vat'=>$this->total_price_without_vat,
            'vat'=>$this->vat ,
            'vat_amount'=>$this->vat_amount,
            'total_price_with_vat'=>$this->total_price_with_vat,


        ];
    }
}
