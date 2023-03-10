<?php
namespace App\Http\Controllers;
use App\Services\CostCenterService;
use App\Services\DepartmentService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:setting-list', ['only' => ['index']]);
        $this->middleware('permission:setting-update', ['only' => ['save']]);
    }

    public function index()
    {
        $settings = SettingService::all();
        $departments = (new DepartmentService())->getDropdownList();
        $costCenter = (new CostCenterService())->getDropdownList();
        $departments_selected = SettingService::get('departments');
        $costCenters_selected = SettingService::get('cost_centers');

        if(!$departments_selected){
            $departments_selected = null;
        }
        return view("settings.index", compact([
            "settings",
            'departments',
            'costCenter',
            'departments_selected',
            'costCenters_selected'
        ]));
    }

    public function save(Request $request)
    {
        $unexpected = [
            "_token"
        ];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $unexpected) === false) {
                SettingService::updateOrCreate($key, $value);
            }
        }
        // To get new updated/created data into settings cache, we need to reload cache settings
        SettingService::reloadSettingsCache();
        session()->flash("message", message("Operation Succeed."));
        return redirect()->back();
    }
}
