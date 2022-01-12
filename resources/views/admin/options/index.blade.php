@extends('layouts.app')
@section('title','Настройки')
@section('header','Настройки')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-9">
                <main-options-list></main-options-list>
            </div>
        </div>
    </div>
@endsection
