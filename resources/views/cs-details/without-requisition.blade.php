<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="company_name">Delivery location</label>
            {!! Form::text("delivery_location", null, ["class"=>"form-control"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="data_order">Budget Info</label>
            {!! Form::select("budget_info", config("constants.budget_info"), null, ["class"=>"select2 form-control custom-select"]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="cost_center_id">Cost Center</label>
            {!! Form::select("cost_center_id", $costCenter, null, ["class"=>"select2 form-control", "placeholder"=>"Cost Center Id"]) !!}
            <span class="validation-error">{{ $errors->first("cost_center_id") }}</span>
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="requisitions">PR List</label>
            {!! Form::select("requisitions[]", $prDropdown,null, ["class"=>"select2 form-control custom-select","multiple"=>True]) !!}

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="cost_center_id">Justification for Procurement</label>
            {!! Form::textarea("justification_for_procurement", null, ["class"=>"form-control","rows" => 2]) !!}
            <span class="validation-error">{{ $errors->first("cost_center_id") }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="cost_center_id">Description</label>
            {!! Form::textarea("description", null, ["class"=>"form-control","rows" => 2]) !!}
            <span class="validation-error">{{ $errors->first("description") }}</span>
        </div>
    </div>
</div>
