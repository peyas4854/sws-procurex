@extends('layouts.master')

@section("page_title") Change Password @endsection

@section("content_header") Change Password @endsection

@section('content')
    <section class="simple-validation" id="vertical-wizard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Set New Password</h5>
                        <div class="heading-elements">
                            <a href="{{url('dashboard')}}" class="btn btn-light-secondary mr-1 mb-1">
                                <i class="bx bx-left-arrow-alt"></i> Back to dashboard
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-body">
                                {!! Form::open(['url' => 'change-password']) !!}
                                @include('profile.password-form')

                                <button type="submit" class="btn btn-primary mr-1 mb-1"><i class="bx bxs-save"></i> Update</button>
                                {!!validationHintsMessage()!!}
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


