@extends('layouts.app')
@section('title','Редактирование страницы')
@section('header','Редактирование страницы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('pages.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <edit-page></edit-page>
            </div>
        </div>
    </div>
@endsection
