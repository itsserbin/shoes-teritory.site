@extends('layouts.app')

@section('title', 'Редактирование цветов')
@section('header', 'Редактирование цветов')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.colors') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <colors-list></colors-list>
            </div>
        </div>
@endsection
