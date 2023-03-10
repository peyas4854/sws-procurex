@extends('layouts.master')

@section("page_title")
    Purchase Requisition(PR)
@endsection

@section("content_header")
    Purchase Requisition(PR)
@endsection
@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Purchase Requisition(PR)</h5>
                        <div class="heading-elements">
                            <a href="{{url('requisitions')}}" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <requisition-form :user_id="{{$user_id}}"
                          :create_mode="true"
        />

    </section>

@endsection
