<?php

namespace App\Http\Resources;

use App\Helpers\Parser;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderEditResource extends JsonResource
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
            'po_code'=>$this->po_code,
            'vendor_id'=>$this->vendor_id,
            'application_date'=>Parser::parseDate($this->application_date),
            'delivery_date'=>$this->delivery_date ? Parser::parseDate($this->delivery_date):$this->delivery_date,
            'delivery_location'=>$this->delivery_location,
            'cost_center_id'=>$this->cost_center_id,
            'procurement_type'=>$this->procurement_type,
            'budget_info'=>$this->budget_info,
            'status'=>$this->status,
            'status_date'=>$this->status_date ? Parser::parseDate($this->status_date):$this->status_date,
            'terms_and_condition'=>$this->terms_and_condition,
            'total_price_without_vat'=> moneyFormatBangladesh($this->total_price_without_vat),
            'total_price_with_vat'=> moneyFormatBangladesh($this->total_price_with_vat),
            'revert_mode'=>true,
            'purchase_order_item' =>PurchaseOrderDetailResource::collection($this->purchaseOrderDetail),
        ];
    }
}
