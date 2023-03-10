<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="contact_person">Contact Person <small class='validation-hints'>*</small></label>
            {!! Form::text('contact_person', null, ['class' => 'form-control', 'placeholder' => 'Contact Person']) !!}
            <span class="validation-error">{{ $errors->first('contact_person') }}</span>
        </div>
        <div class="form-group">
            <label for="contact_email">Contact's Email <small class='validation-hints'>*</small></label>
            {!! Form::email('contact_email', null, ['class' => 'form-control', 'placeholder' => 'contact@email.com']) !!}
            <span class="validation-error">{{ $errors->first('contact_email') }}</span>
        </div>
        <div class="form-group">
            <label for="contact_phone">Contact's Phone <small class='validation-hints'>*</small></label>
            {!! Form::text('contact_phone', null, ['class' => 'form-control', 'placeholder' => 'Contact Phone']) !!}
            <span class="validation-error">{{ $errors->first('contact_phone') }}</span>
        </div>
        <div class="form-group">
            <label for="position">Contact's Role/Position </label>
            {!! Form::text('position', null, ['class' => 'form-control', 'placeholder' => 'Contact Role or Position']) !!}
            <span class="validation-error">{{ $errors->first('position') }}</span>
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                {!! Form::radio('is_default', '1', true, ['class' => 'form-check-input', 'id'=>'radioActive']) !!} 
                <label class="form-check-label" for="radioActive">Default Contact </label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('is_default', '0', false,['class' => 'form-check-input', 'id'=>'radioInactive']) !!}
                <label class="form-check-label" for="radioInactive">Secondary Contact </label>
            </div>
            <span><small class='validation-hints'>*</small></span>
            <span class="validation-error">{{ $errors->first("is_default") }}</span>
        </div>
        {!! Form::hidden('contactable_id', $data['id']) !!}
        {!! Form::hidden('contactable_type', $data['type']) !!}

    </div>
</div>
