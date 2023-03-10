<?php

namespace App\Http\View\Composers;

use App\Models\User;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MasterComposer
{
    private $user;

    public function compose(View $view)
    {
        $this->user = auth()->user();

        $settings = new SettingService();

        $dateFormat = $settings->get("date_format", "Y-m-d");
        $jsDateFormat = config("settings.js_date_format.{$dateFormat}");

        $auto_logoff_time_in_minutes = $settings->get("auto_logoff_time_in_minutes", 5);

        $notification_count = $this->user->unreadNotifications->count();

//        $user_info = $this->getUserInfoFromSession();

        $view->with([
            "jsDateFormat" => $jsDateFormat,
//            "auto_logoff_time_in_minutes" => $auto_logoff_time_in_minutes,
//            "settings_url" => url("settings"),
//            "name" => $user_info["name"],
//            "email" => $user_info["email"],
//            "lastlogin" => $user_info["lastlogin"],
//            "network_ip" => $user_info["network_ip"],
//            "type" => $user_info["type"],
//            "profile_photo" => $user_info["profile_photo"],
//            "running_job" => DB::table("jobs")->count(),
//            "notification_count" => $notification_count,
//            "business_unit_name" => $user_info["business_unit_name"],
//            "business_unit_id" => $user_info["business_unit_id"]
            "notification_count" => $notification_count,

        ]);
    }

    public function getUserInfoFromSession() :array
    {
        if(session()->has("user_info")){
            return session()->get("user_info");
        }
        $user = User::with("employee")->find($this->user->id);

        $user_info = [
            "name" => isset($this->user->employee->full_name) ? $this->user->employee->full_name : "Super Admin",
            "email" => $this->user->email,
            "lastlogin" => $this->user->lastlogin,
            "network_ip" => $this->user->network_ip,
            "type" => ucfirst($this->user->type),
            "profile_photo" => asset(''.isset($this->user->employee->profile_photo) ? $this->user->employee->profile_photo : '/assets/images/default-avatar-male-alt.png'),
            "business_unit_name" => $user->employee->businessUnit->name ?? "N/A",
            "business_unit_id" => $user->employee->business_unit_id ?? null
        ];

        session()->put("user_info", $user_info);

        return $user_info;
    }
}
