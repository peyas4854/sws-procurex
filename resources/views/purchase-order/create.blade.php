@extends('layouts.master')

@section("page_title")
    Purchase Order(PO)
@endsection

@section("content_header")
    Purchase Order(PO)
@endsection
@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Purchase Order(PO)</h5>
                        <div class="heading-elements">
                            <a href="{{url('purchase-orders')}}" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <purchase-order-form/>
@endsection
