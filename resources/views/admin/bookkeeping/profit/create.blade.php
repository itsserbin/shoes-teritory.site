@extends('layouts.app')
@section('title','Подсчитать прибыль за день')
@section('header','Подсчитать прибыль за день')

@section('content')
    <div class="container">

        @component('admin.components.breadcrumbs')
            @slot('active')Бухгалтерия@endslot
            @slot('active_link'){{route('admin.bookkeeping.index')}}@endslot
            @slot('subsidiary')Подсчитать прибыль за день@endslot
        @endcomponent
        <hr>

        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-profits-create></bookkeeping-profits-create>
            </div>
        </div>
@endsection
