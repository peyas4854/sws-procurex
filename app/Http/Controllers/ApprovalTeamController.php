<?php

namespace App\Http\Controllers;

use App\ApprovalTeam;
use App\Services\ApprovalTeamService;
use Illuminate\Http\Request;
use App\Http\Requests\ApprovalTeams\SaveFormRequest;
use App\Http\Requests\ApprovalTeams\UpdateFormRequest;
use App\Services\EmployeeService;
use Gate;

class ApprovalTeamController extends Controller
{
    protected $approval_teamService;
    protected $employeeService;

    public function __construct()
    {
        $this->approval_teamService = new ApprovalTeamService();
        $this->employeeService = new EmployeeService();
        // Initiate Permission
        $this->middleware('permission:approval-team-list', ['only' => ['index']]);
        $this->middleware('permission:approval-team-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:approval-team-view', ['only' => ['show']]);
        $this->middleware('permission:approval-team-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:approval-team-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $data = $request->all();
        $approval_teams = $this->approval_teamService->lists($data);
        $search = $request->search;
        return view("approval_teams.list", compact(["approval_teams", "search"]));
    }

    public function create()
    {
        return view("approval_teams.create");
    }

    public function edit($id)
    {
        $approval_team = $this->approval_teamService->getById($id);
        $idsArray = json_decode($approval_team->employee_ids);

        $preSelected = $this->employeeService->getPreSelectedList($idsArray);
        return view("approval_teams.edit", compact(["approval_team", "preSelected"]));
    }

    public function store(SaveFormRequest $request)
    {

        $validatedData = $request->validated();

        $approval_team = $this->approval_teamService->updateOrCreate($validatedData);

        if(is_null($approval_team) === false){
            $message = message("ApprovalTeam has been successfully created.");
        }else{
            $message = message("ApprovalTeam has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function update(UpdateFormRequest $request)
    {
        $validatedData = $request->validated();

        $approval_team = $this->approval_teamService->updateOrCreate($validatedData);

        if(is_null($approval_team) === false){
            $message = message("ApprovalTeam has been successfully updated.");
        }else{
            $message = message("ApprovalTeam has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function show($id)
    {
        $approval_team = $this->approval_teamService->getById($id);

        // if (Gate::denies('view', $approval_team)) {
        //     return view("errors.403");
        // }

        return view("approval_teams.view", compact(["approval_team"]));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $approval_team = $this->approval_teamService->getById($id);

        // if (Gate::denies('delete', $approval_team)) {
        //     return view("errors.403");
        // }

        $response = $this->approval_teamService->delete($approval_team);

        if($response === true){
            $message = message("ApprovalTeam has been successfully deleted.");
        }else{
            $message = message("ApprovalTeam has not deleted.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
