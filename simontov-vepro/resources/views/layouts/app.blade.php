<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_sedang.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ env('MIX_URL') }}">

    <meta name="user-session" content="{{ auth()->user()->id }}">

    <!-- TITLE -->
    <title>{{ str_replace('-', ' ', config('app.name', 'Laravel')) }}</title>


    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">

    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ asset('assets/colors/color1.css') }}" />


    @yield('styles')

    <script>
        window.success = {
            save: '{{ __('messages.success.save') }}',
            update: '{{ __('messages.success.update') }}',
            delete: '{{ __('messages.success.delete') }}',
            find: '{{ __('messages.success.find') }}',
            title: '{{ __('messages.success.title') }}',
        }

        window.button = {
            save: '{{ __('messages.button.save') }}',
            update: '{{ __('messages.button.update') }}',
            delete: '{{ __('messages.button.delete') }}',
            find: '{{ __('messages.button.find') }}',
            deleteYes: '{{ __('messages.button.deleteYes') }}',
            deleteNo: '{{ __('messages.button.deleteNo') }}',
        }

        window.modal = {
            new: '{{ __('messages.modal.new') }}',
            update: '{{ __('messages.modal.update') }}',
            detail: '{{ __('messages.modal.detail') }}',
        }

        window.modalAlert = {
            alert: '{{ __('messages.delete.alert') }}',
            alertText: '{{ __('messages.delete.alertText') }}',
            failed: '{{ __('messages.delete.failed') }}',
            unauthorize: '{{ __('messages.delete.unauthorize') }}',
        }
    </script>

</head>

<body class="{{ session()->get('theme') ?? 'light-mode' }}">


    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('assets') }}/images/loader.svg" class="loader-img" alt="Loader">
    </div>

    <!-- /GLOBAL-LOADER -->


    <!-- PAGE -->
    <div class="page">
        <div class="page-main">


            <!-- HEADER -->
            @include('components.header')
            <!-- End HEADER -->


            <!-- Mobile Header -->
            @include('components.mobile-header')
            <!-- /Mobile Header -->


            <!--/Horizontal-main -->
            <div class="sticky">
                <div class="horizontal-main hor-menu clearfix">
                    <div class="horizontal-mainwrapper container clearfix">
                        <!--Nav-->
                        @include('components.horizontal-menu')
                        <!--Nav-->
                    </div>
                </div>
            </div>

            <!--/Horizontal-main -->


            <!--app-content open-->
            <div class="app-content hor-content">
                <div class="container">

                    <!-- PAGE-HEADER -->
                    @if (!Request::is('home'))
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">
                                    {{ config('app.name', 'atqiyacode') }}
                                </h1>
                                {{ Breadcrumbs::render() }}
                            </div>
                            @yield('button-add')
                        </div>
                    @else
                        <div class="my-3">
                        </div>
                    @endif

                    <!-- PAGE-HEADER END -->

                    @yield('content')

                    <div id="container-tester"></div>

                    @yield('modal')

                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>


        <!-- FOOTER -->
        @include('components.footer')
        <!-- FOOTER CLOSED -->
    </div>


    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
