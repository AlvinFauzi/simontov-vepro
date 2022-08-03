@extends('layout.auth')

@section('content')

<div class="col col-login mx-auto">
    <div class="text-center">
        <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="">
    </div>
</div>
<div class="container-login100">
    <div class="wrap-login100 p-0">
        <div class="card-body">
            <form class="login100-form validate-form needs-validation" method="POST" action="{{ route('register') }}"
                novalidate>
                @csrf
                <span class="login100-form-title">
                    {{ __('Register') }}
                </span>
                <div class="wrap-input100 validate-input">
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required
                        placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                    @error('email')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required
                        placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                        required placeholder="{{ __('Password') }}" autocomplete="new-password">
                    @error('password')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="wrap-input100 validate-input">
                    <input class="form-control" type="password" name="password_confirmation"
                        required placeholder="{{ __('Confirm Password') }}" autocomplete="new-password">
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
            <div class="text-end pt-1 my-2">
                <p class="mb-0">
                    <a href="{{ route('login') }}" class="text-primary ms-1">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
