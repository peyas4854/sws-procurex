@if (Session::get('incompleteRow'))
    <div class="alert alert-danger dyn-height">
        <p>{{ count(Session::get('incompleteRow')) }}  Excel row are incomplete.</p>
        @foreach(Session::get('incompleteRow') as $row)
            <ul>
                <li>Name: {{ isset($row['name']) ? $row['name'] : 'Name column not found or please check this column again' }}</li>
                <ul>
                    <li>Name : {{ isset($row['name']) ? $row['name'] : 'Name field is required' }}</li>
                </ul>
            </ul>
        @endforeach
        <div></div>
    </div>
    <div>
        <a href="{{ url('vendor/reload') }}" class="btn btn-dark">Close</a>
    </div>
@endif
