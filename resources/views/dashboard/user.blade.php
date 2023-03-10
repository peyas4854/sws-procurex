@extends('layouts.master')

@section("page_title") Admin Dashboard @endsection


@section('content')
    <!-- BEGIN: Content-->
    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        @if(isset($employee))
        <div class="row">

            <!-- Website Analytics Starts-->
            <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                <div class="card">
                    <div class="card-header">
                        <h3 class="greeting-text">Hi, {{$employee->first_name}}!</h3>
                        <p class="mb-0">Greetings. </p>
                    </div>
                    <div class="card-content">

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="dashboard-content-left">

                                </div>
                                <div class="dashboard-content-right">

{{--                                    @if(!is_null($employee->profile_photo))--}}
{{--                                        <img src="{{ $employee->profile_photo }}" class="img-fluid" alt="{{$employee->full_name}}" width="200" height="200">--}}
{{--                                    @else--}}
                                        <img src="/assets/images/default-avatar-{{ $employee->gender ? $employee->gender : 'male'}}.png" class="img-fluid" alt="{{$employee->full_name}}" width="200" height="200">
{{--                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Personal Details</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="position: relative;">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>Full Name:</td>
                                    <td class="users-view-name">{{$employee->full_name}}</td>
                                </tr>
                                @if(!is_null($employee->email))
                                    <tr>
                                        <td>E-mail:</td>
                                        <td class="users-view-email">{{ $employee->email }}</td>
                                    </tr>
                                @endif
                                @if(!is_null($employee->phone))
                                    <tr>
                                        <td>Phone:</td>
                                        <td>{{ $employee->phone }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Code:</td>
                                    <td>{{ $employee->code }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Professional Details</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="position: relative;">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>Employee Code:</td>
                                    <td>{{ $employee->code }}</td>
                                </tr>
                                @if(!is_null($employee->designation_id))
                                    <tr>
                                        <td>Designation:</td>
                                        <td>{{ $employee->designation->name  ?? "" }}</td>
                                    </tr>
                                @endif

                                @if(!is_null($employee->department_id))
                                    <tr>
                                        <td>Department:</td>
                                        <td>{{ $employee->department->name  ?? "" }}</td>
                                    </tr>
                                @endif
                                @if(!is_null($employee->cost_center_id))
                                    <tr>
                                        <td>Cost Center:</td>
                                        <td>{{ $employee->costCenter->name  ?? "" }}</td>
                                    </tr>
                                @endif

{{--                                    <tr>--}}
{{--                                        <?php $role = auth()->user()->getRoleNames() ?>--}}
{{--                                        <td>Role:</td>--}}
{{--                                        <td> {{ count($role) == 0 ? ' - ': implode(",",json_decode($role))  }}</td>--}}
{{--                                    </tr>--}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
    <!-- Dashboard Analytics end -->
@endsection
@section("script")

@endsection
