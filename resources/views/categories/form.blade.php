<div class="row">
    <div class="col-md-12">
        <div class="form-group">
    <label for="name">Name <small class='validation-hints'>*</small></label>
    {!! Form::text("name", null, ["class"=>"form-control", "placeholder"=>"Name"]) !!}
    <span class="validation-error">{{ $errors->first("name") }}</span>
</div>
<div class="form-group">
    <label for="description">Description </label>
    {!! Form::text("description", null, ["class"=>"form-control", "placeholder"=>"Description"]) !!}
    <span class="validation-error">{{ $errors->first("description") }}</span>
</div>
<div class="form-group">
    <label for="category_code">Category Code </label>
    {!! Form::text("category_code", null, ["class"=>"form-control", "placeholder"=>"Category Code"]) !!}
    <span class="validation-error">{{ $errors->first("category_code") }}</span>
</div>
<div class="form-group">
    <label for="parent_category_id">Parent Category Id </label>
    {!! Form::select("parent_category_id", $category_options, null, ["class"=>"select2 form-control", "placeholder"=>"Parent Category Id"]) !!}
    <span class="validation-error">{{ $errors->first("parent_category_id") }}</span>
</div>
    </div>
</div>