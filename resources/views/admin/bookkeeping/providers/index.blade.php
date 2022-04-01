@extends('layouts.app')

@section('title','Поставщики')
@section('header','Поставщики')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.providers') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <providers-list></providers-list>
            </div>
        </div>
@endsection
