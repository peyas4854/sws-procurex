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
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="checkbox">
                {!! Form::checkbox("permission-group-all", "all", null, ["id"=>"all", "class"=>"checkbox-input", "data-group"=>"all"]) !!}
                <label for="all">All</label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach (config("features") as $model => $feature)
    <div class="col-3">
        <div class="card widget-todo">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title d-flex">
                    <div class="checkbox checkbox-shadow">
                        {!! Form::checkbox("permission-group-{$model}", "{$model}", null, ["id"=>"{$model}", "class"=>"checkbox-input all", "data-group"=>"all"]) !!}
                        <label for="{{$model}}">{{ $feature["name"] }}</label>
                    </div>
                </h4>
            </div>
            <div class="card-body px-0 py-1">
                <ul class="widget-todo-list-wrapper">
                    @foreach ($feature["actions"] as $key => $action)
                        <li class="widget-todo-item">
                            <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                <div class="widget-todo-title-area d-flex align-items-center">
                                    <div class="checkbox checkbox-shadow">
                                        {!! Form::checkbox("permissions[]", "{$action}", null, ["id"=>"{$model}.{$key}", "class"=>"checkbox-input {$model} all", "data-group"=>"{$model}"]) !!}
                                        <label for="{{$model}}.{{$key}}"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">{{ $action }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
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
