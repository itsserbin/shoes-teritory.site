@extends('layouts.app')
@section('title','Настройки')
@section('header','Настройки')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <main-options-list></main-options-list>
            </div>
        </div>
    </div>
@endsection
