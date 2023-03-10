<?php

namespace App\Http\Resources;

use App\Helpers\Parser;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
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
            'employee'=>$this->employee ? $this->employee->name_code : '' ,
            'employee_id'=>$this->employee_id,
            'is_forwarded'=>$this->is_forwarded,
            'authority_order'=>$this->authority_order,
            'status'=>$this->status,
            'processed_by'=>$this->processed_by,
            'created_at'=>Parser::parseDateTime($this->created_at),
            'status_date'=>$this->status_date ? Parser::parseDateTime($this->status_date) :'',
            'approval_stage'=>$this->approval_stage,
            'description'=>$this->description,
        ];
    }
}
