@extends('layouts.master')

@section("page_title") Settings @endsection

@section("content_header") Settings @endsection

@section('content')
    @php
        $weekly_holidays = App\Services\SettingService::get('weekly_holidays');

        if(!$weekly_holidays){
          $weekly_holidays = null;
        }

    @endphp
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Settings</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::model($settings, ["url"=>"setting/save", "class"=>"form-horizontal r-separator"]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        {!! Form::text("company_name", null, ["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_info">Tax information</label>
                                        {!! Form::text("tax_info", null, ["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Company Address</label>
                                        {!! Form::textarea("address", null, ["class"=>"form-control",'rows'=>'2',]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        {!! Form::text("phone", null, ["class"=>"form-control "]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        {!! Form::email("email", null, ["class"=>"form-control "]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="website_url">Website Url</label>
                                        {!! Form::url("website_url", null, ["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_order">Data Order</label>
                                        {!! Form::select("data_order", config("settings.data_order"), null, ["class"=>"select2 form-control custom-select"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="item_per_page">Item Per Page</label>
                                        {!! Form::select("item_per_page", config("settings.item_per_page"), null, ["class"=>"select2 form-control custom-select"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="data_order">Date Format</label>
                                        {!! Form::select("date_format", config("settings.date_format"), null, ["class"=>"select2 form-control custom-select"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email_notifications">Email Notifications</label>
                                        {!! Form::select("email_notifications", config("settings.email_notifications"), null, ["class"=>"select2 form-control custom-select"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="weekly_holidays">Weekly Holidays</label>
                                        {!! Form::select("weekly_holidays[]", config("settings.weekly_holidays"),isset($weekly_holidays) ? json_decode($weekly_holidays):null, ["class"=>"select2 form-control custom-select","multiple"=>True]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item_per_page">
                                    Auto logoff&nbsp;
                                    <i class="bx bxs-help-circle" data-toggle="tooltip" data-placement="top" title="If system is keep ideal for [X] minutes, it will be automatically log off and you will have to re-enter your password to access system again. [X] = the number of minutes that you will set."></i>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">after</span>
                                    </div>
                                    {!! Form::number("auto_logoff_time_in_minutes", null, ["class"=>"form-control", "min"=>1]) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">minutes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="weekly_holidays">Domain for api</label>
                                        {!! Form::text("domain_api",null,["class"=>"form-control", "placeholder"=>"Domain for api"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="weekly_holidays">Auth Token</label>
                                        {!! Form::text('auth_token',null, ["class"=>"form-control", "placeholder" => "Auth Token"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="weekly_holidays">Changeable  Cost center for departments</label>
                                        {!! Form::select("departments[]", $departments,isset($departments_selected) ? json_decode($departments_selected):null, ["class"=>"select2 form-control custom-select","multiple"=>True]) !!}

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="weekly_holidays">Starting Notification days</label>
                                        {!! Form::text('notification_days',null, ["class"=>"form-control", "placeholder" => "starting notification days"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="finance_ids">Select Cost center for Department head Approval </label>
                                        {!! Form::select("cost_centers[]", $costCenter,isset($costCenters_selected) ? json_decode($costCenters_selected):null, ["class"=>"select2 form-control custom-select","multiple"=>True]) !!}

                                    </div>

                                </div>
                            </div>
                            @can('setting-update')
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Save</button>
                            @endcan
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
