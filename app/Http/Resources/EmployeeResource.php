<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'full_name'=>$this->first_name ." ". $this->middle_name. " " .$this->last_name. " " .$this->code,
            'department'=>$this->department ? new DepartmentResource($this->department):'',
            'designation'=>$this->designation ? new DesignationResource($this->designation):'',
        ];
    }
}
