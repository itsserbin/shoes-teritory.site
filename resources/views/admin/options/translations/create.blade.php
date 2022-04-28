@extends('layouts.app')
@section('title', 'Добавление перевода')
@section('header', 'Добавление перевода')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.translations.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-translation></create-translation>
            </div>
        </div>
    </div>
@endsection
