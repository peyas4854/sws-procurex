<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="category_id">Category </label>
            {!! Form::select("category_id", $category, null, ["class"=>"select2 form-control", "placeholder"=>"Category Id"]) !!}
            <span class="validation-error">{{ $errors->first("category_id") }}</span>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="brand_id">Brand </label>
            {!! Form::select("brand_id", $brand, null, ["class"=>"select2 form-control", "placeholder"=>"Brand Id"]) !!}
            <span class="validation-error">{{ $errors->first("brand_id") }}</span>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="uom_id">Uom </label>
            {!! Form::select("uom_id", $uom, null, ["class"=>"select2 form-control", "placeholder"=>"Uom Id"]) !!}
            <span class="validation-error">{{ $errors->first("uom_id") }}</span>
        </div>
    </div>



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
    <div class="col-md-6">
        <div class="form-group">
            <label for="price">Price </label>
            {!! Form::text("price", null, ["class"=>"form-control", "placeholder"=>"Price"]) !!}
            <span class="validation-error">{{ $errors->first("price") }}</span>
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="price_date">Price Date</label>
            {!! Form::text("price_date", null, ["class"=>"form-control datepicker","id"=>"price_date"]) !!}
            <small id="ve-price_date" class="form-text validation-error">{{ $errors->first("price_date") }}</small>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item_type">Item Type </label>
            {!! Form::select("item_type", config("constants.item_type"), null, ["class"=>"select2 form-control", "placeholder"=>"Item Type"]) !!}
            <span class="validation-error">{{ $errors->first("item_type") }}</span>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item_type">Status </label>
            <ul class="list-unstyled mb-0">
                <li class="d-inline-block mr-2 mb-1">
                    <fieldset>
                        <div class="radio">
                            {!! Form::radio("is_active", 1,isset($items->is_active) ? $items->is_active : true ,['id'=>'radio1']) !!}
                            <label for="radio1">Active</label>
                        </div>
                    </fieldset>
                </li>
                <li class="d-inline-block mr-2 mb-1">
                    <fieldset>
                        <div class="radio">
                            {!! Form::radio("is_active", 0,isset($items->is_active) ? $items->is_active : false , ['id'=>'radio2']) !!}
                            <label for="radio2">Inactive</label>
                        </div>
                    </fieldset>
                </li>
            </ul>
        </div>
    </div>

</div>


