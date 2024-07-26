@extends('layouts.authLayout')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold text-center">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary shadow-light">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('register'))
                                        <a class="btn btn-link" href="{{ route('register') }}">
                                            {{ __('Belum punya akun?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container-login100">
        <div class="row wrap-login100">
            <div class="col-sm-6">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('img/logo.png') }}" alt="IMG">
                </div>
            </div>

            <div class="col-sm-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title">
                        {{ __('Login') }}
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label txt1" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="text-center p-t-50">
                        @if (Route::has('register'))
                            <a class="btn btn-link txt2" href="{{ route('register') }}">
                                {{ __('Belum punya akun?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
