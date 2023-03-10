<div class="row">
{{--    <div class="col-md-3">--}}
{{--        <div class="form-group">--}}
{{--            <div class="form-group">--}}
{{--                <label for="name">Procurement Type <small class='validation-hints'>*</small></label>--}}
{{--                {!! Form::select('procurement_type', config('constants.procurement_type'), null, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select type']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-md-3">--}}
{{--        <div class="form-group">--}}
{{--            <div class="form-group">--}}
{{--                <label for="name">Budget Info <small class='validation-hints'>*</small></label>--}}
{{--                {!! Form::select('budget_info', config('constants.budget_info'), null, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select budget info']) !!}--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
    <div class="col-md-3">
        <div class="form-group">
            <div class="form-group">
                <label for="name">Item Type</label>
                {!! Form::select('item_type', config('constants.item_type'), null, ['class' => 'select2 form-control custom-select', 'placeholder' => 'Please select item type']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <label for="name"> Date</label>
        <fieldset class="form-group position-relative has-icon-left">
            <input type="text" name="date_filter" id="date_filter" class="form-control daterange"
                   placeholder="Select Date Range">
            <div class="form-control-position">
                <i class="bx bx-calendar-check"></i>
            </div>
        </fieldset>
    </div>

</div>
