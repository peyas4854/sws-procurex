<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateFormRequest;
use App\Http\Requests\Role\UpdateFormRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // Initiate Permission
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-view', ['only' => ['show']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i=0;
        $item_per_page = SettingService::get("item_per_page", 25);
        $order = SettingService::get('data_order', 'desc');

        $roles = Role::orderBy('id',$order)->paginate($item_per_page);
        return view('roles.list',compact('roles', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFormRequest $request)
    {

        $validatedData = $request->validated();

        $role = Role::create(['name' => $validatedData['name']]);
        $role->syncPermissions($validatedData['permissions']);

        $message = message("Role has been successfully created.");

        session()->flash("message", $message);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.view',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = [];

        foreach($role->permissions as $permission){
            $permissions[] = $permission->name;
        }

        $role->permissions = $permissions;

        return view('roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $message = message('Role has been updated.');

        session()->flash("message", $message);

        return redirect('roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Role $role)
    {
        $role->delete();

        $message = message('Role has been deleted.');

        session()->flash("message", $message);

        return redirect('roles');
    }
}
