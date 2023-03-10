<?php

namespace App\Http\Resources;

use App\Helpers\Parser;
use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionEditResource extends JsonResource
{
    protected $approval_stage ='';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'requisition_code' => $this->requisition_code,
            'employee_id' => $this->employee_id,
            'cost_center_id' => $this->cost_center_id,
            'files' => $this->getMedia(),
            'department_id' => $this->employee ? $this->employee->department ?$this->employee->department->id:'':'',
            'designation_id' => $this->employee ? $this->employee->designation ?$this->employee->designation->id:'':'',
            'item_type' => $this->item_type,
            'requisition_details' =>RequisitionDetailsEditResource::collection($this->requisitionDetails),
            'application_date' => Parser::parseDate($this->application_date),
            'required_date' => $this->required_date ? Parser::parseDate($this->required_date): $this->required_date,
            'procurement_type' => $this->procurement_type,
            'budget_info' => $this->budget_info,
            'delivery_location' => $this->delivery_location,
            'contact_person_name_and_number' => $this->contact_person_name_and_number,
            'description' => $this->description,
            'sub_total' => $this->approximate_cost,
            'status' => $this->status,
            'revert_mode'=>true,
            'it_team_edit_access'=>itTeamEditAccess(),
            'item_price_edit_access'=>itemPriceEditAccess(),
            'approval' => itTeamEditAccess() ? ApprovalResource::collection($this->approval):false,
            'approval_id'=>$this->approvalId(ApprovalResource::collection($this->approval)),
            'approval_access' => $this->approvalTeam(ApprovalResource::collection($this->approvalAccess)),
            'approval_stage'=>$this->approval_stage,
            'revert_access'=>self::revertAccess($this->status,$this->employee_id),
            'forward_access'=>forwardAccess($this->status, $this->approval),

        ];
    }
    public function approvalId($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id) {
                $this->approval_stage = $value['approval_stage'];
                return $value['id'];
            }
        }
    }
    public function approvalTeam($data)
    {

        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id && $value['status'] == 'pending') {
                return true;
            }
        }
        return false;
    }

    public function revertAccess($status,$employee_id)
    {
        return ($status=='reverted' ||  $status=='draft') && auth()->user()->employee_id == $employee_id;
    }

}
