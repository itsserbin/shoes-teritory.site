@extends('layouts.app')

@section('title','Добавление пользователя')
@section('header','Добавление пользователя')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-9">
                <create-user></create-user>
            </div>
        </div>
    </div>
@endsection
