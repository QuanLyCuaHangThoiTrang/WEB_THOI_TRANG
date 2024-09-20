<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow" />
    @vite('resources/css/app.css')
    <title>YODY</title>
    
</head>
<body>
    <div>
        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')
    </div>
</body>
</html>
