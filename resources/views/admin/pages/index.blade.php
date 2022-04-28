@extends('layouts.app')
@section('title','Страницы')
@section('header','Страницы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('pages') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <pages-list></pages-list>
            </div>
        </div>
    </div>
@endsection
