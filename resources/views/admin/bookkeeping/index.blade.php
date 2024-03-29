@extends('layouts.app')

@section('title','Бухгалтерия')
@section('header','Бухгалтерия')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping') }}
        <hr>

        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <h2>Статистика по заявкам</h2>
                <bookkeeping-orders-statistics></bookkeeping-orders-statistics>
                <bookkeeping-profits-list></bookkeeping-profits-list>
                <bookkeeping-costs-list></bookkeeping-costs-list>
            </div>
        </div>
    </div>
@endsection
