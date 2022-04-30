@extends('layouts.app')
@section('title','Редактирование отзыва')
@section('header','Редактирование отзыва')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('reviews.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <edit-review></edit-review>
            </div>
        </div>
    </div>
@endsection
