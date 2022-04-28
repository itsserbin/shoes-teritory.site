@extends('layouts.app')
@section('title','Добавить баннер')
@section('header','Добавить баннер')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.banners.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-banner></create-banner>
            </div>
        </div>
    </div>
@endsection
