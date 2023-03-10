<?php

use App\Models\ApprovalTeam;
use App\Models\User;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

function message($message, $type = "success", $close_button = true)
{
    if ($type === "success") {
        $class = "success";
        $icon = "check-circle";
    } elseif ($type === "warning") {
        $class = "warning";
        $icon = "error";
    } elseif ($type === "error") {
        $class = "danger";
        $icon = "error";
    } elseif ($type === "info") {
        $class = "info";
        $icon = "info-circle";
    } else {
        $class = "success";
        $icon = "check-circle";
    }

    if ($close_button === true) {
        $close_button_html = "
                <button type='button' class='close' data-dismiss='alert'>
                    <span aria-hidden='true'>×</span>
                    <span class='sr-only'>Close</span>
                </button>
            ";
    } else {
        $close_button_html = "";
    }

    $html = "
            <div class='alert alert-$class mb-2'>
                $close_button_html
                <i class='bx bxs-$icon'></i> $message
            </div>
        ";

    return $html;
}

function shorten_urlSegment($segment)
{
    if (!is_null($segment)) {
        $segment_length = strlen($segment);
        if ($segment_length > 30) {
            return substr($segment, 0, 6);
        }
    }

    return $segment;
}

function passwordValidationHintsMessage()
{
    return "<small class='validation-hints'><i class='fa fa-info-circle'></i> #Note: Password should be minimum 8 character</small>";
}

function validationHintsMessage()
{
    return "<small class='validation-hints'><i class='fa fa-info-circle'></i> All fields marked with an asterisk (*) are required.</small>";
}

/**
 * Display pagination summery
 *
 * @param int $total_data
 * @param int $data_per_page
 * @param int $current_page
 */
function get_pagination_summary($data)
{

    $total_item = $data->total();
    $item_per_page = $data->perPage();
    $current_page = $data->currentPage();

    $pagination_summary = "";
    if ($total_item > $item_per_page) {
        if ($current_page == 1) {
            $pagination_summary = "Showing 1 to $item_per_page records of $total_item";
        } else {
            if (($total_item - $current_page * $item_per_page) > $item_per_page) {
                $from = ($current_page - 1) * $item_per_page + 1;
                $to = $current_page * $item_per_page;
                $pagination_summary = "Showing $from to $to records of $total_item";
            } else {
                $from = ($current_page - 1) * $item_per_page + 1;
                $to = ($total_item - ($current_page - 1) * $item_per_page) + ($current_page - 1) * $item_per_page;
                $pagination_summary = "Showing $from to $to records of $total_item";
            }
        }
    }
    return $pagination_summary;
}

function moneyFormatBangladesh($num)
{

    try {
        return number_format($num);
    } catch (\Exception $ex) {
        ErrorNotifierService::notifyException($ex);
        return 0;
    }
}

function moneyFormatInTk($amount)
{
    $number = sprintf('%0.2f', $amount);
    $tk = moneyFormatBangladesh($number);
    return 'Tk. ' . $tk;
}

function numberFormat($num)
{
    return number_format($num, 2);
}

function statusStyle($status)
{

    if ($status == 'draft')
        $style = "dark";
    else if ($status == 'rejected')
        $style = "danger";
    else if ($status == 'approved')
        $style = "success";
    else if ($status == 'reverted')
        $style = "secondary";
    else if ($status == 'pending')
        $style = "warning";
    else $style = "success";


    return '<div class="badge badge-pill badge-'. $style . ' mr-1">' . $status . '</div>';
}

function getUser($employee_id)
{
    return User::select(["users.id", "users.email"])
        ->join("employees as e", "e.user_id", "users.id")
        ->where("e.id", $employee_id)
        ->whereNotNull("e.user_id")
        ->first();
}

function dateFormate()
{
    $settings = new SettingService();
    $dateFormat = $settings->get("date_format", "Y-m-d");
    return config("settings.js_date_format.{$dateFormat}");
}

function itemType()
{
    return config("constants.item_type");
}

function budgetInfo()
{
    return config("constants.budget_info");
}

function procurementType()
{
    return config("constants.procurement_type");
}

function vatList()
{
    return config("constants.vat_list");
}

function csDetailPermission()
{
    $approvalTeam = \App\Models\ApprovalTeam::query()->where('name', 'cs_approval_hod')
        ->orWhere('name', 'cs_approval_panel')->pluck('employee_ids');
    $employees = [];
    foreach ($approvalTeam as $team) {
        foreach (json_decode($team) as $employeeId) {
            array_push($employees, $employeeId);
        }
    }
    $csDetailAccess = false;
    foreach ($employees as $user) {
        $userId = \App\Models\Employee::query()->findOrFail($user)->user_id;
        if (auth()->id() == $userId || auth()->user()->type == 'hq-admin' || auth()->user()->type == 'admin') {
            $csDetailAccess = true;
        }
    }
    return $csDetailAccess;
}

function approvalStage($collection)
{

    $count = $collection->count();

    $value = ($collection && $count > 0) ? $collection[0]->approval_stage : '';

    return ucwords(str_replace('_', ' ', $value));

}

function itTeamEditAccess()
{
    $editAccess = false;
    $query = ApprovalTeam::query()->whereIn('name', ['it_team','procurement_team'])->select('employee_ids');

    $itTeamAccess = false;
    if ($query->exists()) {
        foreach ($query->get() as $team){
            $employeesId = json_decode($team->employee_ids);
            if (auth()->user()->employee) {
                $itTeamAccess = in_array(auth()->user()->employee->id, $employeesId);
            }
        }
    }

    $itDepartmentAccess = false;
    $department = auth()->user()->employee->department;

    if ($department && $department->name == 'IT') {
        $itDepartmentAccess = true;
    }

    if ($itTeamAccess || $itDepartmentAccess) {
        $editAccess = true;
    }


    return $editAccess;
}

function forwardAccess($status,$collection)
{
    $approval_stage =  approvalStage($collection);

    $value = false;
    if (auth()->user()->can('pr-forward') && $status == 'pending') {
        $value = true;
    }

    if (auth()->user()->employee->department->name == 'IT' && $status == 'pending' && $approval_stage== 'It Team') {
        $value = true;
    }

    return $value;

}
function itemPriceEditAccess(){
    $editAccess = false;
    $query = ApprovalTeam::query()->where('name', 'procurement_team')->select('employee_ids');

    if ($query->exists()) {
        foreach ($query->get() as $team){
            $employeesId = json_decode($team->employee_ids);
            if (auth()->user()->employee) {
                $editAccess = in_array(auth()->user()->employee->id, $employeesId);
            }
        }
    }
    return $editAccess;
}


