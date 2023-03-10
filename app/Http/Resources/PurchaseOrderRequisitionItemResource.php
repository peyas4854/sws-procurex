<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderRequisitionItemResource extends JsonResource
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
            'requisition_detail_id'=>$this->id,
            'quantity'=>$this->quantity,
            'uom'=>$this->uom->name,
            'uom_id'=>$this->uom_id,
            'item'=>$this->item->name,
            'item_id'=>$this->item_id,
            'category_name'=>$this->item->category ? $this->item->category->name:'',
            'category_id'=>$this->item->category ? $this->item->category->id:'',
            'brand'=>$this->brand,
            'description'=>$this->description,
            'requisition_code'=>$this->requisition->requisition_code,
            'unit_price'=>$this->unit_price,
            'total_price_without_vat'=>$this->price,
            'vat'=>numberFormat(0),
            'vat_amount'=>numberFormat(0),
            'total_price_with_vat'=>$this->price,

        ];
    }

}
