<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Name <small class='validation-hints'>*</small></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            <span class="validation-error">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="cost_center_code">Cost Center Code </label>
            {!! Form::text('cost_center_code', null, ['class' => 'form-control', 'placeholder' => 'Cost Center Code']) !!}
            <span class="validation-error">{{ $errors->first('cost_center_code') }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="description">Description </label>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows'=> '2' ,'placeholder' => 'Description']) !!}
            <span class="validation-error">{{ $errors->first('description') }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="finance_ids">Business Unit Head</label>
            {!! Form::select('buHeads[]', isset($buheadIds) ? $preSelectedBuHead : [],
            isset($buheadIds) ? $buheadIds: null, ['id' => 'bu-head-select', 'multiple' => 'true', 'class' => 'select2 form-control']) !!}
            <span class="validation-error">{{ $errors->first('finance_ids') }}</span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="finance_ids">Finance Approver </label>
            {!! Form::select('finance_ids[]', isset($financeAppvovalIds) ? $preSelectedFinance : [],
            isset($financeAppvovalIds) ? $financeAppvovalIds: null, ['id' => 'finance-approver-select', 'multiple' => 'true', 'class' => 'select2 form-control']) !!}
            <span class="validation-error">{{ $errors->first('finance_ids') }}</span>
        </div>
    </div>

</div>


