<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('admin/app.css') }}">
</head>
<body>
<div id="app">
    @include('admin.components.navigation')
    <header class="bg-white shadow">
        <h1 class="max-w-7xl mx-auto p-4">
            @yield('header')
        </h1>
    </header>

    <main class="py-4">
        <div class="container">
            <div class="row">
{{--                <div class="col-md-2">--}}
{{----}}
{{--                </div>--}}
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

</div>

<script src="{{asset('admin/admin.js') }}"></script>
</body>
</html>
