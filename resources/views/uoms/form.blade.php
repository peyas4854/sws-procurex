<div class="row">
    <div class="col-md-12">
        <div class="form-group">
    <label for="name">Name <small class='validation-hints'>*</small></label>
    {!! Form::text("name", null, ["class"=>"form-control", "placeholder"=>"Name"]) !!}
    <span class="validation-error">{{ $errors->first("name") }}</span>
</div>
<div class="form-group">
    <label for="description">Description </label>
    {!! Form::textarea("description", null, ["class"=>"form-control", "rows" => 3, "placeholder"=>"Description"]) !!}
    <span class="validation-error">{{ $errors->first("description") }}</span>
</div>
    </div>
</div>