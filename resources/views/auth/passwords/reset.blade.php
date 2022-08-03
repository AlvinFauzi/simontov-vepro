@extends('layouts.auth')

@section('content')
    <div class="col col-login mx-auto">
        <div class="text-center">
            <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="">
        </div>
    </div>
    <div class="container-login100">
        <div class="wrap-login100 p-0">
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}" class="card shadow-none">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="text-center">
                        <div class="col col-login mx-auto">
                            <div class="text-center">
                                <img src="{{ asset('images/logo_kecil.png') }}" class="img-fluid mb-lg-3" alt="">
                            </div>
                        </div>
                        <span class="login100-form-title">
                            {{ __('lang.reset-password') }}
                        </span>
                        <p class="text-muted">{{ trans('lang.reset-password-text') }}</p>
                    </div>
                    <div class="pt-3" id="forgot">
                        <div class="form-group">
                            <label class="form-label">{{ __('lang.email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" required autocomplete="email" autofocus placeholder="{{ __('lang.email') }}"
                                value="{{ $email ?? old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('lang.password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ __('lang.password_confirmation') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                        <div class="submit">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('lang.reset-password') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
