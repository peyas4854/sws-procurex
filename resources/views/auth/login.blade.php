@extends('layouts.public-master')

@section("page_title")
    Login
@endsection

@section('content')
    <section id="auth-login" class="row flexbox-container">
        <div class="col-xl-8 col-11">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <!-- <h2 class="text-center"> Procurement</h2> -->
                                    <img class="img-fluid mx-auto d-block" style="max-height: 60px;" src="{{asset('assets/images/login-logo.png')}}" alt="ProcureX logo">
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="mb-1">
                                    <a href="{{url('/hrm')}}" type="button" class="btn btn-light-info btn-block"><i
                                            class="fa-brands fa-facebook"></i> Login with TalentX </a>
                                </p>

                                {!! session()->get('message') !!}
                                {!! Form::open(["url"=>url('authenticate')]) !!}
                                <div class="form-group mb-50">
                                    <label class="text-bold-600" for="identity">Email or username</label>
                                    {!! Form::text("identity", null, ["class"=>"form-control", "placeholder" => "Email or username ", "autofocus"=>true]) !!}
                                    <small class="validation-error">{{ $errors->first("identity") }}</small>
                                </div>
                                <div class="form-group">
                                    <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                    {!! Form::password("password", ["class"=>"form-control", "placeholder" => "Password"]) !!}
                                    <small class="validation-error">{{ $errors->first("password") }}</small>
                                </div>
                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                    <div class="text-left">
                                        <div class="checkbox checkbox-sm">
                                            {!! Form::checkbox("remember", 1, false, ["class"=>"form-check-input", "id"=>"chkRemember"]) !!}
                                            <label class="checkboxsmall" for="chkRemember">
                                                <small>Keep me logged in</small>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- <div class="text-right"><a href="#" class="card-link"><small>Forgot Password?</small></a></div> -->
                                </div>
                                <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <div class="card-content">
                            <img class="img-fluid" src="{{asset('assets/images/values-small.gif')}}"
                                 alt="Procurex Values">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
