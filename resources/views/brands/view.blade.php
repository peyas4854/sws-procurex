@extends('layouts.master')

@section("page_title") Brand @endsection

@section("content_header") Brand @endsection

@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Brand: ??</h5>
                        <div class="heading-elements">

                                <a href="{{route('brands.index')}}" class="btn btn-light-secondary mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {{ $brand->toJson() }}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
