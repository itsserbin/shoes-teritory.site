@extends('layouts.app')

@section('title','Категории расходов')
@section('header','Категории расходов')

@section('content')
    <div class="container">

        {{ Breadcrumbs::render('bookkeeping.costs.categories') }}
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-categories-list></bookkeeping-costs-categories-list>
            </div>
        </div>
    </div>
@endsection
