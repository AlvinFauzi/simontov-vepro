@extends('layouts.auth')

@section('content')
    <div class="container-login100">
        <div class="row">
            <div class="col col-login mx-auto">
                <form method="POST" action="{{ route('password.confirm') }}" class="card shadow-none">
                    @csrf
                    <div class="card-body">
                        <div class="text-center">
                            <div class="col col-login mx-auto">
                                <div class="text-center">
                                    <img src="{{ asset('images/logo_kecil.png') }}" class="img-fluid mb-lg-3" alt="">
                                </div>
                            </div>
                            <span class="login100-form-title">
                                {{ __('lang.confirm-password') }}
                            </span>
                            <p class="text-muted">{{ __('lang.confirm-password-text') }}</p>
                        </div>
                        <div class="pt-3" id="forgot">
                            <div class="form-group">
                                <label class="form-label">{{ __('lang.password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="submit">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('lang.confirm-password') }}
                                </button>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="text-center mt-4">
                                    <p class="text-dark mb-0">
                                        <a class="text-primary ms-1" href="{{ route('password.request') }}">
                                            {{ __('lang.forgot-password?') }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
