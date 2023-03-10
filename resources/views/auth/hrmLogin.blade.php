@extends('layouts.public-master')

@section("page_title") Login @endsection

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
                                <img class="img-fluid mx-auto d-block" style="max-height: 60px;" src="{{asset('assets/images/talent-x.png')}}" alt="Talent X logo">
                            </div>
                        </div>
                        <div class="card-content">
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                            @endif

                            <form method="POST" action="{{ route('hrm.login') }}">
                                @csrf
                            <div class="form-group mb-50">
                                <label for="email" class=""> Username</label>
                                    <input id="username" type="text" class="form-control @error('email') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                    <div class="text-left">
                                        <div class="checkbox checkbox-sm">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                <small>Keep me logged in</small>
                                            </label>
                                        </div>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a> -->
                                    @endif
                                </div>
                            <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <div class="card-content">
                        <img class="img-fluid" src="{{asset('assets/images/values-small.gif')}}" alt="ShopUp Values">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
