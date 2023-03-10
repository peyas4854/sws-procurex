<?php

namespace App\Services;

use App\Models\ApprovalTeam;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class ApprovalTeamService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = ApprovalTeam::query();

        // if(isset($data["search"])){

        //     $search_query = [
        //         "search" => $data["search"]
        //     ];

        //     $query->where(function($q) use($data){
        //         $q->orWhere("name", "LIKE", "%".$data["search"]."%");
        //     });
        // }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $approval_teams = $query->paginate($item_per_page)->appends($search_query);
            $approval_teams->pagination_summary = get_pagination_summary($approval_teams);
        } else {
            $approval_teams = $query->get();
        }

        return $approval_teams;
    }

    public function updateOrCreate($data)
    {

        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update
            //dd('update');
            $approval_team = ApprovalTeam::whereId($data["id"])->first();
            $approval_team->updated_by = $user_id;
        } else {
            //create

            $approval_team = new ApprovalTeam();
            $approval_team->created_by = $user_id;
        }

        $approval_team->name = $data['name'];

        if (isset($data['employee_ids'])) {

            $approval_team->employee_ids = json_encode($data['employee_ids']);

        }

        if (isset($data['detail'])) {
            $approval_team->detail = $data['detail'];
        }

        return $approval_team->save() ? $approval_team : null;
    }

    public function getById($id)
    {
        return ApprovalTeam::find($id);
    }

    public function delete($approval_team)
    {
        $approval_team = $approval_team->delete();
        return $approval_team;
    }

    public function getTeamMembers($team)
    {
        $members = ApprovalTeam::query()
            ->where('name', $team)
            ->pluck('employee_ids')->first();
        return json_decode($members);

    }

    public function team($team)
    {
        $query = ApprovalTeam::query()->where('name',$team);

        if($query->exists()){
            $team = $query->pluck('employee_ids')->first();
            return  (new EmployeeService())->teamEmployee(json_decode($team));
        }else{
            return [];
        }



    }
}
