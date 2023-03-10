@extends('layouts.master')
@section("page_title")
    CS
@endsection
@section("content_header")
    CS
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">CS </h5>
                        <div class="heading-elements">
                            <a href="{{url('cs-details')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">


                            @include('cs-details.show.without-requisition')

                            @include('cs-details.show.approval-requisition')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
