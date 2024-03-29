@extends('layouts.app')

@section('title','Добавить расход')
@section('header','Добавить расход')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.costs.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-create></bookkeeping-costs-create>
            </div>
        </div>
    </div>
@endsection
