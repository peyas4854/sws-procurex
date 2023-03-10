@extends('layouts.master')

@section("page_title") User List @endsection

@section("content_header") User List @endsection

@section('content')
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">User List ({{ $users->total() }})</h5>
                    <div class="heading-elements">
                        @can('mass-role-assign')
                        <a href="{{ url("mass/role") }}" class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-list-ul"></i> Mass Role Assign
                        </a>
                        @endcan

                        @can('role-list')
                            <a href="{{ route("roles.index") }}" class="btn btn-primary mr-1 mb-1">
                                <i class="bx bx-list-ul"></i> Role List
                            </a>
                        @endcan
                            @can('role-create')
                                <a href="{{ route("roles.create") }}" class="btn btn-danger mr-1 mb-1">
                                    <i class="bx bx-plus-circle"></i> Create New Role
                                </a>
                            @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(["url" => url("users"),"method"=>"GET"]) !!}
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_id"> Employee </label>
                                    {!! Form::select("employee_id",$employee, request("employee_id"), ["class"=>"select2 form-control", "placeholder"=>"Select Employee"]) !!}
                                    <small class="text-muted form-text validation-error">{{ $errors->first("employee_id") }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_id"> User Type </label>
                                    {!! Form::select("type",$types, $request->type, ["class"=>"select2 form-control", "placeholder"=>"Select user type"]) !!}
                                    <small class="text-muted form-text validation-error">{{ $errors->first("employee_id") }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role"> Role </label>
                                    {!! Form::select("role", $roles,request("role"), ["class"=>"select2 form-control", "placeholder"=>"Select Role"]) !!}
                                    <span class="validation-error">{{ $errors->first("role") }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 form-group d-flex align-items-center pt-2">
                                <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bx-search"></i> Search</button>
                                <a href="{{ url("users") }}" class="btn btn-dark mr-1 mb-1"> Refresh</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email/Username</th>
                                    <th>User Type</th>

                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name ?? "--" }}</td>
                                        <td>{{ $user->email }} / {{ $user->username }}</td>
                                        <td>{{ $user->type }}</td>
                                        <td>{{ implode(",",json_decode($user->getRoleNames()))  }}</td>
                                        <td>{{ ( $user->active == '1' ) ? 'Active' : 'In Active' }}</td>
                                        <td>{{ \App\Helpers\Parser::parseDate($user->created_at) }}</td>
                                        <td class="text-center">
                                            @if(auth()->user()->id == $user->id)
                                            @else
                                                @if(!isset($user->user_id))

                                                @else
                                                    @can('user-edit')
                                                        <a href="{{url('users/edit')}}/{{ $user->id }}" class="btn btn-icon btn-success glow mr-1 mb-1"><i class="bx bx-edit-alt"></i></a>
                                                        @endcan
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Records</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">
                                        @if(!empty($users->pagination_summary))
                                            <span class="label label-primary">{{ $users->pagination_summary }}</span>
                                        @endif
                                    </td>
                                    <td colspan="4">
                                        <div class="pull-right">{{ $users->links() }}</div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
