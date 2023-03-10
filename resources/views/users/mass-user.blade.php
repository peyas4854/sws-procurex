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

                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open(["url" => url("mass/role/assign")]) !!}
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_id"> Employee </label>
                                    {!! Form::select("employee_id[]",$employee, request("employee_id"), ['class' => 'select2 form-control','multiple' => 'true']) !!}
                                    <small class="text-muted form-text validation-error">{{ $errors->first("employee_id") }}</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role"> Role </label>
                                    {!! Form::select("role[]", $roles, request("role"), ["class"=>"select2 form-control", "placeholder"=>"Select Role"]) !!}
                                    <span class="validation-error">{{ $errors->first("role") }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 form-group d-flex align-items-center pt-2">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Assign</button>
{{--                                <a href="{{ url("users") }}" class="btn btn-dark mr-1 mb-1"> Refresh</a>--}}
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
                                    <th>Role</th>
                                    <th>Status</th>


                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name ?? "--" }}</td>
                                        <td>{{ $user->email }} / {{ $user->username }}</td>
                                        <td>{{ implode(",",json_decode($user->getRoleNames()))  }}</td>
                                        <td>{{ ( $user->active == '1' ) ? 'Active' : 'In Active' }}</td>
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
