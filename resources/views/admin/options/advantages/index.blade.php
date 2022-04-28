@extends('layouts.app')
@section('title', 'Настройка преимуществ')
@section('header', 'Настройка преимуществ')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.advantages') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <advantages-list></advantages-list>
            </div>
        </div>
    </div>
@endsection
