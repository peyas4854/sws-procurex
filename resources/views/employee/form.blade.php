<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="department_id">Department Id </label>
            {!! Form::select("department_id", $department, null, ["class"=>"select2 form-control", "placeholder"=>"Department Id"]) !!}
            <span class="validation-error">{{ $errors->first("department_id") }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="designation_id">Designation Id </label>
            {!! Form::select("designation_id", $designation, null, ["class"=>"select2 form-control", "placeholder"=>"Designation Id"]) !!}
            <span class="validation-error">{{ $errors->first("designation_id") }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="cost_center_id">Cost Center Id </label>
            {!! Form::select("cost_center_id", $costCenter, null, ["class"=>"select2 form-control", "placeholder"=>"Cost Center Id"]) !!}
            <span class="validation-error">{{ $errors->first("cost_center_id") }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="code">Code <small class='validation-hints'>*</small></label>
            {!! Form::number("code", null, ["class"=>"form-control", "placeholder"=>"Code"]) !!}
            <span class="validation-error">{{ $errors->first("code") }}</span>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="first_name">First Name <small class='validation-hints'>*</small></label>
            {!! Form::text("first_name", null, ["class"=>"form-control", "placeholder"=>"First Name"]) !!}
            <span class="validation-error">{{ $errors->first("first_name") }}</span>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="middle_name">Middle Name </label>
            {!! Form::text("middle_name", null, ["class"=>"form-control", "placeholder"=>"Middle Name"]) !!}
            <span class="validation-error">{{ $errors->first("middle_name") }}</span>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="last_name">Last Name </label>
            {!! Form::text("last_name", null, ["class"=>"form-control", "placeholder"=>"Last Name"]) !!}
            <span class="validation-error">{{ $errors->first("last_name") }}</span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Phone </label>
            {!! Form::text("phone", null, ["class"=>"form-control", "placeholder"=>"Phone"]) !!}
            <span class="validation-error">{{ $errors->first("phone") }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email </label>
            {!! Form::text("email", null, ["class"=>"form-control", "placeholder"=>"Email"]) !!}
            <span class="validation-error">{{ $errors->first("email") }}</span>
        </div>
    </div>


    <div class="col-md-12">
        {{--        <div class="form-group">--}}
        {{--            <label for="profile_photo">Profile Photo </label>--}}
        {{--            {!! Form::text("profile_photo", null, ["class"=>"form-control", "placeholder"=>"Profile Photo"]) !!}--}}
        {{--            <span class="validation-error">{{ $errors->first("profile_photo") }}</span>--}}
        {{--        </div>--}}
        <div class="form-group">
            <label for="item_type">Status </label>
            <ul class="list-unstyled mb-0">
                <li class="d-inline-block mr-2 mb-1">
                    <fieldset>
                        <div class="radio">
                            {!! Form::radio("status", 1,isset($employees->status) ? $employees->status : true ,['id'=>'radio1']) !!}
                            <label for="radio1">Active</label>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2 mb-1">
                    <fieldset>
                        <div class="radio">
                            {!! Form::radio("status", 0,isset($employees->status) ? $employees->status : false , ['id'=>'radio2']) !!}
                            <label for="radio2">Inactive</label>
                        </div>
                    </fieldset>
                </li>
            </ul>
        </div>

    </div>
</div>
