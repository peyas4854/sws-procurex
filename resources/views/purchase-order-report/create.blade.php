@extends('layouts.master')

@section("page_title")
    Purchase Order (PO) Reports
@endsection

@section("content_header")
    Purchase Order (PO) Reports
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"> Purchase Order (PO) Reports</h5>
                        <div class="heading-elements">

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['url' => 'purchase-order/show', "method"=>"GET"]) !!}

                            @include('purchase-order-report.form')
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx
                                    bxs-report"></i> Generate Report
                            </button>
                            {!!validationHintsMessage()!!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')

@endsection
