@extends('layouts.auth')

@section('content')
    <div class="container-login100">
        <div class="row">
            <div class="col col-login mx-auto">
                <form method="POST" action="{{ route('password.email') }}" class="card shadow-none">
                    @csrf
                    <div class="card-body">
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
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="{{ __('lang.email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="submit">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('lang.send-reset-password-link') }}
                                </button>
                            </div>
                            <div class="text-center mt-4">
                                <p class="text-dark mb-0">{{ trans('lang.remember-password') }}<a
                                        class="text-primary ms-1"
                                        href="{{ route('login') }}">{{ trans('lang.sign-in') }}</a>
                                </p>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
