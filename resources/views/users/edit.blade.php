@extends('layouts.master')

@section("page_title") User Edit @endsection

@section("content_header") User Edit @endsection

@section('content')
    <section class="simple-validation">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit User</h5>
                        <div class="heading-elements">
                                <a href="{{url('users')}}" class="btn btn-light mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {!! Form::model($user, ['url' => 'users/update']) !!}
                            @include('users.form')

                            {!! Form::hidden('id') !!}
                            <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Update</button>
                            @can('list', \App\User::class)
                                <a href="{{url('users')}}" class="btn btn-light mr-1 mb-1">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @else
                                <a href="#" class="btn btn-light mr-1 mb-1 disabled">
                                    <i class="bx bx-left-arrow-alt"></i> Back to list
                                </a>
                            @endcan
                            {!!validationHintsMessage()!!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
