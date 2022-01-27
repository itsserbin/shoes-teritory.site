@extends('layouts.app')

@section('title','Статистика продаж')
@section('header','Статистика продаж')

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
                <bookkeeping-daily-statistics
                    administrator-role="{{json_encode(auth()->check() && auth()->user()->hasRole('administrator'))}}"
                    admin-permission="{{json_encode(Gate::allows('admin'))}}"
                ></bookkeeping-daily-statistics>
            </div>
        </div>
    </div>
@endsection
