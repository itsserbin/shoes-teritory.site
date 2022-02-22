@extends('layouts.app')

@section('title','Добавить категорию расходов')
@section('header','Добавить категорию расходов')

@section('content')
    <div class="container">

        {{ Breadcrumbs::render('bookkeeping.costs.categories.create') }}
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-categories-create></bookkeeping-costs-categories-create>
            </div>
        </div>
    </div>
@endsection
