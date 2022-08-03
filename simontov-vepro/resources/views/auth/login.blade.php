@extends('layouts.auth')


@section('content')
    <div class="container-login100">
        <div class="wrap-login100 p-0">
            <div class="card-body">
                <form class="login100-form validate-form needs-validation" method="POST" action="{{ route('login') }}"
                    novalidate>
                    @csrf
                    <div class="col col-login mx-auto">
                        <div class="text-center">
                            <img src="{{ asset('images/logo_kecil.png') }}" class="img-fluid mb-lg-3" alt="">
                        </div>
                    </div>
                    <span class="login100-form-title">
                        {{ __('Login') }}
                    </span>
                    <div class="wrap-input100 validate-input">
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" required
                            placeholder="{{ trans('lang.email') }}" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                            required placeholder="{{ trans('lang.password') }}">
                        @error('password')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <label class="custom-control custom-checkbox mt-4">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span class="custom-control-label">
                            {{ __('lang.remember-me') }}
                        </span>
                    </label>


                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn btn-primary">
                            {{ __('lang.sign-in') }}
                        </button>
                    </div>
                </form>
                @if (Route::has('password.request'))
                    <div class="text-end pt-1 my-2">
                        <p class="mb-0">
                            <a href="{{ route('password.request') }}" class="text-primary ms-1">
                                {{ __('lang.forgot-password?') }}
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
