<?php

namespace App\Http\Resources;

use App\Helpers\Parser;
use App\Models\ApprovalTeam;
use Illuminate\Http\Resources\Json\JsonResource;

class RequisitionResource extends JsonResource
{
    protected $approval_stage ='';
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'requisition_code' => $this->requisition_code,
            'item_type' =>config("constants.item_type.$this->item_type"),
            'cost_center' => $this->costcenter ?$this->costcenter->name : '',
            'employee' => new EmployeeResource($this->employee),
            'application_date' => Parser::parseDate($this->application_date),
            'required_date' => $this->required_date,
            'procurement_type' => $this->procurement_type,
            'procurement_list' => config("constants.procurement_type"),
            'budget_info' => $this->budget_info,
            'budget_list' => config("constants.budget_info"),
            'delivery_location' => $this->delivery_location,
            'approximate_cost' => moneyFormatInTk($this->approximate_cost),
            'status' => $this->status,
            'contact_person_name_and_number' => $this->contact_person_name_and_number,
            'description' => $this->description,
            'reqisition_details' => RequisitionDetailsResource::collection($this->requisitionDetails),
            'created_at' => Parser::parseDate($this->created_at),
            'approval' => ApprovalResource::collection($this->approval),
            'files' => $this->getMedia(),
            'approval_access' => $this->approvalTeam(ApprovalResource::collection($this->approvalAccess)),
            'approval_id'=>$this->approvalId(ApprovalResource::collection($this->approval)),
            'approval_stage'=>$this->approval_stage,
            'forward_access'=>forwardAccess($this->status,$this->approval),
            'it_team_edit_access'=>itTeamEditAccess(),
            'export_access'=>self::requisitionExportAccess(),
            'pr_master_access'=>self::prMasterAccess(),
            'reinitiate'=> self::reInitialPermission($this->status,$this->approval),
        ];
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

    public function approvalId($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id) {
                $this->approval_stage = $value['approval_stage'];
                return $value['id'];
            }
        }
    }

    public function requisitionExportAccess()
    {
        return (bool)auth()->user()->can('requisition-export');
    }
    public function prMasterAccess()
    {
        return (bool)auth()->user()->can('pr-approve-revert-reject');
    }

    public function reInitialPermission($status,$approvals)
    {
        $stage = $approvals->sortDesc()->first();

        return (auth()->user()->type =='hq-admin' && $status=='pending' && $stage->approval_stage !='procurement_team' && $stage->status =='approved');
    }


}
