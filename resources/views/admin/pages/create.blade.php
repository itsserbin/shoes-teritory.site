@extends('layouts.app')
@section('title','Добавление страницы')
@section('header','Добавление страницы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('pages.create') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <create-page></create-page>
            </div>
        </div>
    </div>
@endsection
