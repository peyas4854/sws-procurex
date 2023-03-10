<div class="row">
    <div class="col-md-12">
        <div class="form-group">

            <div class="form-group">
                <label for="name">Name <small class='validation-hints'>*</small></label>
                {!! Form::select('name', config('constants.approval_team'), null, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select team']) !!}
                <span class="validation-error">{{ $errors->first('name') }}</span>
            </div>

        </div>
        <div class="form-group">
            <label for="employee_ids">Employee Ids </label>
            {{-- @inject('employeeService', 'App\Services\employeeService') --}}
            {{-- {!! Form::select('employee_ids[]', $employeeService->getDropdownList(), isset($approval_team->employee_ids) ? json_decode($approval_team->employee_ids) : null, ['multiple' => 'true', 'class' => 'select2 form-control']) !!} --}}
            {!! Form::select('employee_ids[]', isset($approval_team->employee_ids) ? $preSelected : [], 
            isset($approval_team->employee_ids) ? json_decode($approval_team->employee_ids) : null, ['id' => 'approval-team-select', 'multiple' => 'true', 'class' => 'select2 form-control']) !!}
            <span class="validation-error">{{ $errors->first('employee_ids') }}</span>
        </div>
        <div class="form-group">
            <label for="detail">Detail </label>
            {!! Form::textarea('detail', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Detail']) !!}
            <span class="validation-error">{{ $errors->first('detail') }}</span>
        </div>
    </div>
</div>
