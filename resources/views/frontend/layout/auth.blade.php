<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ mix('/assets/css/app.css') }}">
    <script>
        var _auth = <?php echo json_encode(Auth::check() ? Auth::user()->api_token : '')?>;
    </script>
    @yield('head')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>

<script src="{{ mix('/assets/js/manifest.js') }}"></script>
<script src="{{ mix('/assets/js/vendor.js') }}"></script>
<script src="{{ mix('/assets/js/app.js') }}"></script>
@yield('js')
</html>
