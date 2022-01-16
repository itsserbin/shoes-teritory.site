@extends('layouts.app')

@section('title','Пользователи')
@section('header','Пользователи')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <users-list></users-list>
            </div>
        </div>
    </div>
@endsection
