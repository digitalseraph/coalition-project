<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @stack('pre-styles')
    <link href="{{ mix('/assets/css/all.css') }}" rel="stylesheet">
    @stack('post-styles')

    <!-- HTML5 Shim and Respond.js -->
    @include('layouts.partials._shim')
</head>
<body>
    <div id="app">
        <!-- Navigation Bar (top) -->
        @include('layouts.partials._navbar')

        <!-- Content Header (Page header) -->
        @include('layouts.partials._page-header')

        <!-- Main Content Area -->
        @yield('content')

        <!-- Navigation Bar (footer) -->
        @include('layouts.partials._footer-navbar')
    </div>


    <!-- Scripts -->
    @stack('pre-scripts')
    <script src="{{ mix('/assets/js/manifest.js') }}"></script>
    <script src="{{ mix('/assets/js/vendor.js') }}"></script>
    <script src="{{ mix('/assets/js/all.js') }}"></script>
    @stack('post-scripts')
</body>
</html>
