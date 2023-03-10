@extends('layouts.master')

@section("page_title") Department @endsection

@section("content_header") Department @endsection

@section('content')
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Department: ??</h5>
                    <div class="heading-elements">
                        @can('list', \App\Department::class)
                            <a href="{{url('departments')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{ $department->toJson() }}

                        @can('list', \App\Department::class)
                            <a href="{{url('departments')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light-secondary mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection