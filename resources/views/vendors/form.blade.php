
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="vendor_code">Vendor Code <small class='validation-hints'>*</small></label>
            {!! Form::text('vendor_code', null, ['class' => 'form-control', 'placeholder' => 'Vendor Code']) !!}
            <span class="validation-error">{{ $errors->first('vendor_code') }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="name">Name <small class='validation-hints'>*</small></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            <span class="validation-error">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="address">Address <small class='validation-hints'>*</small></label>
            {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Address']) !!}
            <span class="validation-error">{{ $errors->first('address') }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="office_phone">Office Phone <small class='validation-hints'>*</small></label>
            {!! Form::text('office_phone', null, ['class' => 'form-control', 'placeholder' => 'Office Phone']) !!}
            <span class="validation-error">{{ $errors->first('office_phone') }}</span>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="office_email">Office Email <small class='validation-hints'>*</small></label>
            {!! Form::text('office_email', null, ['class' => 'form-control', 'placeholder' => 'Office Email']) !!}
            <span class="validation-error">{{ $errors->first('office_email') }}</span>
        </div>
    </div>
    <div class="col-md-3">

{{--        <div class="form-group">--}}
{{--            <div class="form-check form-check-inline">--}}
{{--                {!! Form::radio('status', '1', true, ['class' => 'form-check-input', 'id'=>'radioActive']) !!}--}}
{{--                <label class="form-check-label" for="radioActive">Active </label>--}}
{{--            </div>--}}
{{--            <div class="form-check form-check-inline">--}}
{{--                {!! Form::radio('status', '0', false,['class' => 'form-check-input', 'id'=>'radioInactive']) !!}--}}
{{--                <label class="form-check-label" for="radioInactive">Inactive </label>--}}
{{--            </div>--}}
{{--            <span><small class='validation-hints'>*</small></span>--}}
{{--            <span class="validation-error">{{ $errors->first("status") }}</span>--}}
{{--        </div>--}}
        <div class="form-group">
        <label for="item_type">Status </label>
        <ul class="list-unstyled mb-0">
            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                    <div class="radio">
                        {!! Form::radio("status", 1,isset($vendor->status) ? $vendor->status : true ,['id'=>'radioActive']) !!}
                        <label for="radioActive">Active</label>
                    </div>
                </fieldset>
            </li>
            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                    <div class="radio">
                        {!! Form::radio("status", 0,isset($vendor->status) ? $vendor->status : false , ['id'=>'radioInactive']) !!}
                        <label for="radioInactive">Inactive</label>
                    </div>
                </fieldset>
            </li>
        </ul>
    </div>

    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="bin">Bin </label>
            {!! Form::text('bin', null, ['class' => 'form-control', 'placeholder' => 'Bin']) !!}
            <span class="validation-error">{{ $errors->first('bin') }}</span>
        </div>

    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="tin">Tin </label>
            {!! Form::text('tin', null, ['class' => 'form-control', 'placeholder' => 'Tin']) !!}
            <span class="validation-error">{{ $errors->first('tin') }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="trade_license">Trade License </label>
            {!! Form::text('trade_license', null, ['class' => 'form-control', 'placeholder' => 'Trade License']) !!}
            <span class="validation-error">{{ $errors->first('trade_license') }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_account_name">Bank Account Name </label>
            {!! Form::text('bank_account_name', null, ['class' => 'form-control', 'placeholder' => 'Bank Account Name']) !!}
            <span class="validation-error">{{ $errors->first('bank_account_name') }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_account_number">Bank Account Number </label>
            {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'placeholder' => 'Bank Account Number']) !!}
            <span class="validation-error">{{ $errors->first('bank_account_number') }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_routing_number">Bank Routing Number </label>
            {!! Form::text('bank_routing_number', null, ['class' => 'form-control', 'placeholder' => 'Bank Routing Number']) !!}
            <span class="validation-error">{{ $errors->first('bank_routing_number') }}</span>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_name">Bank Name </label>
            {!! Form::text('bank_name', null, ['class' => 'form-control', 'placeholder' => 'Bank Name']) !!}
            <span class="validation-error">{{ $errors->first('bank_name') }}</span>
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_branch">Bank Branch </label>
            {!! Form::text('bank_branch', null, ['class' => 'form-control', 'placeholder' => 'Bank Branch']) !!}
            <span class="validation-error">{{ $errors->first('bank_branch') }}</span>
        </div>
    </div>


</div>

