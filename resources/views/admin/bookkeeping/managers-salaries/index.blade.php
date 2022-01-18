@extends('layouts.app')

@section('title','Статистика для менеджеров')
@section('header','Статистика для менеджеров')

@section('content')
    <div class="container">

        @component('admin.components.breadcrumbs')
            @slot('active')Бухгалтерия@endslot
            @slot('active_link'){{route('admin.bookkeeping.index')}}@endslot
            @slot('subsidiary')Статистика для менеджеров@endslot
        @endcomponent
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-managers-salaries></bookkeeping-managers-salaries>
            </div>
        </div>
    </div>

@endsection
