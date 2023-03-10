<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Role Name <span class="validation-hints">*</span></label>
            {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control']) !!}
            <span class="validation-error">{{ $errors->first("name") }}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">
                Assign Permissions <span class="validation-hints">*</span>
            </label>
            @if($errors->first("permissions"))
            <span class="validation-error">[{{ $errors->first("permissions") }}]</span>
            @endif
            <div>
                <div class="checkbox">
                    {!! Form::checkbox("permission-group-all", "all", null, ["id"=>"all", "class"=>"checkbox-input", "data-group"=>"all"]) !!}
                    <label for="all">All</label>
                </div>
                <ul id="permissions" class="list-unstyled">
                    @foreach (config("features") as $model => $feature)
                        <li>
                            <div class="checkbox">
                                {!! Form::checkbox("permission-group-{$model}", "{$model}", null, ["id"=>"{$model}", "class"=>"checkbox-input all", "data-group"=>"all"]) !!}
                                <label for="{{$model}}">{{ $feature["name"] }}</label>
                            </div>
                            <ul class="">
                                @foreach ($feature["actions"] as $key => $action)
                                    <li>                                
                                        <div class="checkbox">
                                            {!! Form::checkbox("permissions[]", "{$action}", null, ["id"=>"{$model}.{$key}", "class"=>"checkbox-input {$model} all", "data-group"=>"{$model}"]) !!}
                                            <label for="{{$model}}.{{$key}}">{{ $action }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    $(document).ready(function(){

        @if(isset($role) && count($role->permissions) > 0)
            @foreach($role->permissions as $permission)
                var cb = $("input[type=checkbox][value='{{ $permission }}']");
                controlCheckbox(cb);
            @endforeach
        @endif

        $("input[type=checkbox]").on("change", function(e){
            e.preventDefault();

            controlCheckbox($(this));
        });
    });

    function controlCheckbox(cb)
    {
        var childClass = cb.attr("id")

        if($('.'+childClass).length > 0){
            if(cb.prop("checked") === true){
                $("."+childClass).prop("checked", true);
            }else{
                $("."+childClass).prop("checked", false);
            }
        }

        var group = cb.data("group");
        var numberOfChildCheckBoxes = $('.'+group).length;
        var checkedChildCheckBox = $('.'+group+':checked').length;

        if (checkedChildCheckBox === numberOfChildCheckBoxes){
            $("#"+group).prop('checked', true);
        }else{
            $("#"+group).prop('checked', false);
        }

        if ($('.all').length === $('.all:checked').length){
            $("#all").prop('checked', true);
        }else{
            $("#all").prop('checked', false);
        }

        return true;
    }
</script>
@endsection