@extends('layouts.master')

@section("page_title") Role Details @endsection

@section("content_header") Role Details  @endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Role Details</h5>
                    <div class="heading-elements">

                        <a href="{{ route('roles.index')}}" class="btn btn-primary mr-1 mb-1">
                            <i class="bx bx-list-ul"></i> Role List
                        </a>


                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Name</strong> :  {{ $role->name }} </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Permission ({{ $role->permissions->count() }})</strong> :
                                                @foreach ($role->permissions->chunk(5) as $chunk)
                                                <div class="row">
                                                    @foreach ($chunk as $permission)
                                                        <div class="col"><p>{{ $permission->name }}</p></div>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
