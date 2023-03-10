@extends('layouts.master')

@section('page_title')
    Contact
@endsection

@section('content_header')
    Contact
@endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Contact</h5>
                        <div class="heading-elements">
                            @include('base-component.back-button', [
                                'url' => url()->previous(),
                                'text' => 'Back to list',
                            ])

                            {{-- @can('list', \App\Vendor::class)
                            <a href="{{url('contacts')}}" class="btn btn-light mr-1 mb-1">
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
                            {!! Form::open(['route' => 'contacts.store', 'method' => 'POST']) !!}
                            @include('contacts.form')

                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i>
                                Save</button>
                            @include('base-component.back-button', [
                                'url' => url()->previous(),
                                'text' => 'Back to list',
                            ])
                            {{-- @can('list', \App\Vendor::class)
                                <a href="{{url('contacts')}}" class="btn btn-light mr-1 mb-1">
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
