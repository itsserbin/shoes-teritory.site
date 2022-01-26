<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('admin/app.css') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<div id="app">
    <div class="container">
        <div class="row align-items-center" style="height: 100vh">
            <div class="col-12">
                @include('components.flash-message')
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{asset('admin/admin.js') }}"></script>
</body>
</html>
