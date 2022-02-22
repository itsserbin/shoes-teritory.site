@extends('layouts.app')

@section('title','Добавить категорию расходов')
@section('header','Добавить категорию расходов')

@section('content')
    <div class="container">

        {{ Breadcrumbs::render('bookkeeping.costs.categories.edit') }}
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-categories-edit></bookkeeping-costs-categories-edit>
            </div>
        </div>
    </div>
@endsection
