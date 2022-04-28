@extends('layouts.app')
@section('title', 'Добавление преимущества')
@section('header', 'Добавление преимущества')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.advantages.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-advantage></create-advantage>
            </div>
        </div>
    </div>
@endsection
