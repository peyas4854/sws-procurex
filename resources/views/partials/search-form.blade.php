{!! Form::open(["url" => $url,'method' => 'get']) !!}

<div class="input-group">
    <input type="text" class="form-control" placeholder="{{ $placeholder }}" name="search" value="{{ $search }}">
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
    <div class="input-group-append">
        <a href="{{ $url }}" class="btn btn-info" type="submit">Refresh</a>
    </div>
</div>
{!! Form::close() !!}
