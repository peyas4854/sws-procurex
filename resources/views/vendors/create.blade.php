@extends('layouts.master')

@section('page_title')
    Vendor
@endsection

@section('content_header')
    Vendor
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Vendor</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('vendors'),
                                'text' => 'Back to list',
                            ])
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['route' => 'vendors.store', 'method' => 'POST']) !!}
                            @include('vendors.form')
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Save</button>
                            @include('base-component.back-button', [
                                'url' => url('vendors'),
                                'text' => 'Back to list',
                            ])
                            {!! validationHintsMessage() !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
