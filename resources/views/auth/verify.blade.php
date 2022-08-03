@extends('layouts.auth')

@section('content')
    <div class="col col-login mx-auto">
        <div class="text-center">
            <img src="{{ asset('assets/images/brand/logo.png') }}" class="header-brand-img" alt="">
        </div>
    </div>
    <div class="container-login100">
        <div class="wrap-login100 p-3">
            <div class="card-body">
                <div class="col col-login mx-auto">
                    <div class="text-center">
                        <img src="{{ asset('images/logo_kecil.png') }}" class="img-fluid mb-lg-3" alt="">
                    </div>
                </div>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('clear-session') }}" class="btn btn-primary justify-content-center">
                            <i class="fe fe-home"></i> Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
