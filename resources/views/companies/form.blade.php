<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Name <small class='validation-hints'>*</small></label>
            {!! Form::text("name", null, ["class"=>"form-control", "placeholder"=>"Name"]) !!}
            <span class="validation-error">{{ $errors->first("name") }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="address">Address </label>
            {!! Form::textarea("address", null, ["class"=>"form-control", "rows" => 2, "placeholder"=>"Address"]) !!}
            <span class="validation-error">{{ $errors->first("address") }}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="bin">Bin </label>
            {!! Form::text("bin", null, ["class"=>"form-control", "placeholder"=>"Bin"]) !!}
            <span class="validation-error">{{ $errors->first("bin") }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone_numbers">Phone Numbers </label>
            {!! Form::text("phone_numbers", null, ["class"=>"form-control", "placeholder"=>"Phone Numbers"]) !!}
            <span class="validation-error">{{ $errors->first("phone_numbers") }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="website">Website </label>
            {!! Form::text("website", null, ["class"=>"form-control", "placeholder"=>"Website"]) !!}
            <span class="validation-error">{{ $errors->first("website") }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <fieldset class="form-group">
            <label for="profile_photo">please Upload a <code>jpeg</code> or <code>png</code> or <code>jpg</code>
                file</label>
            <div class="custom-file">
                {!! Form::file("logo", $attributes =["class"=>"custom-file-input"]) !!}
                <label class="custom-file-label" for="profile_photo">Choose file</label>
            </div>
            <span class="validation-error">{{ $errors->first("logo") }}</span>
        </fieldset>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="cost centers">Cost Centers <small class='validation-hints'>*</small></label> <br>
            <span class="validation-error">{{ $errors->first("cost_centers") }}</span>
            <div class="row">
                @foreach ($allCostCenters as $key => $action)
                <div class="col-md-3">
                <ul class="widget-todo-list-wrapper">
                    <li class="widget-todo-item">
                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                            <div class="widget-todo-title-area d-flex align-items-center">
                                @if(in_array( $key, $companies_cost_centers))
                                    @if(isset($checkSelected) && in_array($key,$checkSelected))
                                        <div class="checkbox checkbox-shadow">
                                            {!! Form::checkbox("cost_centers[]", "{$key}",'yes',["id"=>"{$key}", "class"=>"checkbox-input all ","data-group"=>"{$key}"]) !!}
                                            <label for="{{$key}}"> </label>
                                        </div>
                                    @else
                                        <div class="checkbox checkbox-shadow">
                                            {!! Form::checkbox("cost_centers[]", "{$key}", null,array('disabled'),["id"=>"{$key}", "class"=>"checkbox-input all ","data-group"=>"{$key}"]) !!}
                                            <label for="{{$key}}"> </label>
                                        </div>
                                    @endif
                                @else
                                    <div class="checkbox checkbox-shadow">
                                        {!! Form::checkbox("cost_centers[]", "{$key}", null,["id"=>"{$key}", "class"=>"checkbox-input all","data-group"=>"{$key}"]) !!}
                                        <label for="{{$key}}"> </label>
                                    </div>
                                @endif
                                <span class="widget-todo-title ml-50">{{ $action }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

