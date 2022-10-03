<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,600">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=PT+Sans:400,700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cabin:300,500,600">
    <link rel="stylesheet" type="text/css" href="{{ mix('/backend/css/admin.css') }}">
    <script>
        var _auth = <?= json_encode(Auth::user()->api_token) ?>;
    </script>
    @yield('head')
</head>
<body>
    <div id="wrapper">
        <div id="app">
            @include('backend/includes/sidebar')

            <div id="page-content-wrapper">
                @yield('body')
            </div>
        </div>
    </div>
</body>

<script src="{{ mix('/backend/js/manifest.js') }}"></script>
<script src="{{ mix('/backend/js/vendor.js') }}"></script>
<script src="{{ mix('/backend/js/admin.js') }}"></script>
@include('backend/includes/scripts')
@yield('js')
</html>
