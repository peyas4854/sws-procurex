<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exist_password">Current Password<small class='validation-hints'>*</small></label>
                {!! Form::password("exist_password", ["class"=>"form-control", "placeholder"=>"Add Current Password"]) !!}
                <span class="validation-error">{{ $errors->first("exist_password") }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">New Password <small class='validation-hints'>*</small></label>
                {!! Form::password("password", ["class"=>"form-control", "placeholder"=>"Password should be minimum 8 character"]) !!}
                <span class="validation-error">{{ $errors->first("password") }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password_confirmation">Retype Password<small class='validation-hints'>*</small></label>
                {!! Form::password("password_confirmation", ["class"=>"form-control", "placeholder"=>"Retype Password"]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! passwordValidationHintsMessage() !!}
                </div>
            </div>
        </div>
    </div>
</div>
