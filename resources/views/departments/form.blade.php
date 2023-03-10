<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Name <small class='validation-hints'>*</small></label>
            {!! Form::text("name", null, ["class"=>"form-control", "placeholder"=>"Name"]) !!}
            <span class="validation-error">{{ $errors->first("name") }}</span>
        </div>

        <div class="form-group">
            <label for="finance_ids">Department Head </label>
            {!! Form::select('employee_ids[]', isset($departmentHeadIds) ? $preSelectedHead : [],
            isset($departmentHeadIds) ? $departmentHeadIds: null, ['id' => 'department-head-select', 'multiple' => 'true', 'class' => 'select2 form-control']) !!}
            <span class="validation-error">{{ $errors->first('department_ids') }}</span>
        </div>


        <div class="form-group">
            <label for="detail">Detail </label>
            {!! Form::textarea("detail", null, ["class"=>"form-control", "rows" => 3, "placeholder"=>"Detail"]) !!}
            <span class="validation-error">{{ $errors->first("detail") }}</span>
        </div>
    </div>
</div>
