@extends('layouts.app')

@section('title', 'Добавление цвета')
@section('header', 'Добавление цвета')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.colors.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-color></create-color>
            </div>
        </div>
@endsection
