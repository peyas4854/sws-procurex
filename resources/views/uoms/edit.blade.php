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
                        <h5 class="card-title">Edit Uom</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('uoms'),
                                'text' => 'Back to list',
                            ])
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::model($uom, ['method' => 'PATCH', 'route' => ['uoms.update', $uom->id]]) !!}
                            @include('uoms.form')

                            {!! Form::hidden('id') !!}
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Update</button>

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
