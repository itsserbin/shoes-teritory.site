@extends('layouts.app')
@section('title','Подсчитать расход за день')
@section('header','Подсчитать расход за день')

@section('content')

    <div class="container">

        @component('admin.components.breadcrumbs')
            @slot('active')Бухгалтерия@endslot
            @slot('active_link'){{route('admin.bookkeeping.index')}}@endslot
            @slot('subsidiary')Статистика продаж@endslot
        @endcomponent
        <hr>

        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <form action="{{route('admin.bookkeeping.daily-statistics.store')}}" method="POST">
                    @csrf
                    @include('admin.bookkeeping.daily-statistics.partials.form')
                    <button class="btn btn-danger my-3" type="submit">Сохранить</button>
                    <p>* Данные подсчитываються каждую минуту.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
