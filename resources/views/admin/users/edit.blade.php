@extends('layouts.app')

@section('title','Редактирование пользователя')
@section('header','Редактирование пользователя')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-9">
                <edit-user></edit-user>
            </div>
        </div>
    </div>
@endsection
