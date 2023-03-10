<?php

namespace App\Http\Controllers;
use App\Models\ApprovalTeam;
use App\Models\CostCenter;
use App\Models\CostCenterHead;
use Illuminate\Http\Request;

class ProcessInfoController extends Controller
{
    public function index()
    {
        $costCenter = CostCenter::query()->count();
        $buHeadCount =CostCenterHead::query()->pluck('cost_center_id')->unique()->count();

        $itTeam = ApprovalTeam::query()->team('it_team');
        $adminTeam = ApprovalTeam::query()->team('admin_team');
        $procurementTeam= ApprovalTeam::query()->team('procurement_team');
        $csApprovalHod= ApprovalTeam::query()->team('cs_approval_hod');
        $csApprovalPanel= ApprovalTeam::query()->team('cs_approval_panel');
        $chiefBusinessOfficer= ApprovalTeam::query()->team('chief_business_officer');
        $deputyFinanceDirector = ApprovalTeam::query()->team('deputy_finance_director');
        $chiefFinanceOfficer = ApprovalTeam::query()->team('chief_finance_officer');
        $chiefExecutiveOfficer = ApprovalTeam::query()->team('chief_executive_officer');

        return view('process-info.index',compact([
            'costCenter',
            'buHeadCount',
            'itTeam',
            'adminTeam',
            'procurementTeam',
            'csApprovalHod',
            'csApprovalPanel',
            'chiefBusinessOfficer',
            'deputyFinanceDirector',
            'chiefFinanceOfficer',
            'chiefExecutiveOfficer',
        ]));
    }
}
