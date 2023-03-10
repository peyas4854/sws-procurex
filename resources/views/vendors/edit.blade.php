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
                        <h5 class="card-title">Edit Vendor</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url('vendors'),
                                'text' => 'Back to list',
                            ])
                            {{-- @can('list', \App\Vendor::class)
                            <a href="{{url('vendors')}}" class="btn btn-light mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @else
                            <a href="#" class="btn btn-light mr-1 mb-1 disabled">
                                <i class="bx bx-left-arrow-alt"></i> Back to list
                            </a>
                        @endcan --}}
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::model($vendor, ['route' => ['vendors.update', $vendor], 'method' => 'PATCH']) !!}
                            @include('vendors.form')

                            {!! Form::hidden('id') !!}
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Update</button>

                            @include('base-component.back-button', [
                                'url' => url('vendors'),
                                'text' => 'Back to list',
                            ])
                            {{-- @can('list', \App\Vendor::class)
                                <a href="{{url('vendors')}}" class="btn btn-light mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @else
                                <a href="#" class="btn btn-light mr-1 mb-1 disabled">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @endcan --}}
                            {!! validationHintsMessage() !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
