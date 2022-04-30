@extends('layouts.app')
@section('title','Подсчитать зарплату менеджера за день')
@section('header','Подсчитать зарплату менеджера за день')

@section('content')
    <div class="container">

        {{ Breadcrumbs::render('bookkeeping.managers-salaries.create') }}
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-add-day-to-managers-salaries></bookkeeping-add-day-to-managers-salaries>
            </div>
        </div>
    </div>

@endsection
