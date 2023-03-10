@extends('layouts.master')

@section('page_title')
    Uom
@endsection

@section('content_header')
    Uom
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Uom</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('uoms'),
                                'text' => 'Back to list',
                            ])
                         </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::open(['url' => route('uoms.store')]) !!}
                            @include('uoms.form')

                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Save</button>

                            @include('base-component.back-button', [
                                'url' => url('uoms'),
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
