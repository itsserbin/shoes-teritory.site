@extends('layouts.app')

@section('title','Редактирование пользователя')
@section('header','Редактирование пользователя')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.users.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-user></edit-user>
            </div>
        </div>
    </div>
@endsection
