@extends('layouts.app')

@section('title','Добавление пользователя')
@section('header','Добавление пользователя')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.users.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-user></create-user>
            </div>
        </div>
    </div>
@endsection
