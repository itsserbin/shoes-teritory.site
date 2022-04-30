@extends('layouts.app')

@section('title','Прибыль')
@section('header','Прибыль')

@section('content')
    <div class="container">

        {{ Breadcrumbs::render('bookkeeping.profits') }}

        <hr>

        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-profits-list></bookkeeping-profits-list>
            </div>
        </div>
@endsection
