@extends('layouts.app')

@section('title','Статистика по заявкам')
@section('header','Статистика по заявкам')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.orders-statistic') }}
        <hr>
        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-orders-statistics></bookkeeping-orders-statistics>
            </div>
        </div>
    </div>
@endsection
