<div class="col-md-6">
    <div class="form-group">
        <label for="employee_id">Employee Name<small class='validation-hints'>*</small></label>
        {!! Form::select("employee_id",$employees,isset($employeeId) ? $employeeId : null , ["class"=>"select2 form-control", "placeholder"=>"Employee Name"]) !!}
        <span class="validation-error">{{ $errors->first("employee_id") }}</span>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="username">Username<small class='validation-hints'>*</small></label>
        {!! Form::text("username", null, ["class"=>"form-control","id"=>"username", "placeholder"=>"Username"]) !!}
        <span id="usernameText" class="validation-error">{{ $errors->first("username") }}</span>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="password">Password</label>
        {!! Form::password("password", ["class"=>"form-control", "placeholder"=>"password"]) !!}
        <span class="validation-error">{{ $errors->first("password") }}</span>
    </div>
</div>
@if (auth()->user()->isHqAdmin())
    <div class="col-md-6">
        <div class="form-group">
        <label for="type">User Type: <small class='validation-hints'>*</small></label>
            {!! Form::select('type',config("constants.user_type"), null, array('class' => 'form-control','placeholder'=>'Select type')) !!}
            <span class="validation-error">{{ $errors->first("type") }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,isset($userRole) ? $userRole : null, array('class' => 'form-control','placeholder'=>'Select role')) !!}
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! passwordValidationHintsMessage() !!}
        </div>
    </div>
</div>
@section('script')
    <script>

        {{--$('#username').blur(function(){--}}

        {{--    var username = $("#username").val();--}}

        {{--    $.ajax({--}}
        {{--        url:"{{ route('username-available.check') }}",--}}
        {{--        method:"POST",--}}
        {{--        data:{username:username},--}}
        {{--        dataType: 'json',--}}
        {{--        success:function(response){--}}
        {{--            console.log(response);--}}
        {{--            $('#usernameText').html(response);--}}
        {{--        }--}}
        {{--    });--}}


        {{--});--}}
    </script>
@endsection


