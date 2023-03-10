<div class="row">
    <div class="col-md-12">
        <div class="form-group">
    <label for="requisition_code">Requisition Code </label>
    {!! Form::text("requisition_code", null, ["class"=>"form-control", "placeholder"=>"Requisition Code"]) !!}
    <span class="validation-error">{{ $errors->first("requisition_code") }}</span>
</div>
<div class="form-group">
    <label for="cost_center_id">Cost Center Id </label>
    {!! Form::select("cost_center_id", [], null, ["class"=>"select2 form-control", "placeholder"=>"Cost Center Id"]) !!}
    <span class="validation-error">{{ $errors->first("cost_center_id") }}</span>
</div>
<div class="form-group">
    <label for="employee_id">Employee Id <small class='validation-hints'>*</small></label>
    {!! Form::select("employee_id", [], null, ["class"=>"select2 form-control", "placeholder"=>"Employee Id"]) !!}
    <span class="validation-error">{{ $errors->first("employee_id") }}</span>
</div>
<div class="form-group">
    <label for="application_date">Application Date </label>
    {!! Form::text("application_date", null, ["class"=>"form-control", "placeholder"=>"Application Date"]) !!}
    <span class="validation-error">{{ $errors->first("application_date") }}</span>
</div>
<div class="form-group">
    <label for="required_date">Required Date </label>
    {!! Form::text("required_date", null, ["class"=>"form-control", "placeholder"=>"Required Date"]) !!}
    <span class="validation-error">{{ $errors->first("required_date") }}</span>
</div>


<div class="form-group">
    <label for="delivery_location">Delivery Location </label>
    {!! Form::textarea("delivery_location", null, ["class"=>"form-control", "rows" => 3, "placeholder"=>"Delivery Location"]) !!}
    <span class="validation-error">{{ $errors->first("delivery_location") }}</span>
</div>
<div class="form-group">
    <label for="approximate_cost">Approximate Cost </label>
    {!! Form::text("approximate_cost", null, ["class"=>"form-control", "placeholder"=>"Approximate Cost"]) !!}
    <span class="validation-error">{{ $errors->first("approximate_cost") }}</span>
</div>
    </div>
</div>