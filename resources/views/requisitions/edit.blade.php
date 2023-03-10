@extends('layouts.master')

@section("page_title")
    PR
@endsection

@section("content_header")
    PR
@endsection
@section('content')
    <section class="simple-validation">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="align-self-center flex-fill ">
                                <h5 class="card-title"> Purchase Requisition(PR) Edit Reference #{{ $requisition->requisition_code  }} {!! statusStyle($requisition->status) !!} </h5>
                            </div>
                            <div class="align-self-center flex-fill ">
                                Created At : {{ \Carbon\Carbon::parse($requisition->created_at)->format('Y-m-d') }}
                            </div>
                            <div class="heading-elements">
                                <a href="{{url('requisitions')}}" class="btn btn-light mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <requisition-form :user_id="{{$user_id}}" :revert_mode="true" :id="{{$requisition_id}}"/>
    </section>
@endsection
