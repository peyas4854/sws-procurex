@extends('layouts.master')

@section("page_title") Company @endsection

@section("content_header") Company @endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Company</h5>
                        <div class="heading-elements">

                            <a href="{{url('companies')}}" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>

                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            {!! Form::model($company, ['route' => ['companies.update', $company->id], 'method' => 'PATCH','files'=>'true' ]) !!}
                            @include('companies.form')
                            {!! Form::hidden('id') !!}
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Save</button>
                            {!!validationHintsMessage()!!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

