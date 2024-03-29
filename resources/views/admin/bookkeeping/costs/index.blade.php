@extends('layouts.app')

@section('title','Расходы')
@section('header','Расходы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.costs') }}
        <hr>
        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-list></bookkeeping-costs-list>
            </div>
        </div>
    </div>
@endsection
