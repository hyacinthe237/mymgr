<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Asap:300,500,600">
    <link rel="stylesheet" type="text/css" href="{{ mix('/backend/css/admin.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @yield('head')
</head>
<body>
    <div id="app">
        @yield('body')
    </div>
</body>

<script>
window.config = {
    app_name: {!! json_encode(config('app.name')) !!}
}
</script>
<script src="{{ mix('/backend/js/manifest.js') }}"></script>
<script src="{{ mix('/backend/js/vendor.js') }}"></script>
<script src="{{ mix('/backend/js/admin.js') }}"></script>
@yield('js')
</html>
