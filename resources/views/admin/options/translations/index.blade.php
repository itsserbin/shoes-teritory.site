@extends('layouts.app')
@section('title', 'Переводы')
@section('header', 'Переводы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.translations') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <translations-list></translations-list>
            </div>
        </div>
    </div>
@endsection
