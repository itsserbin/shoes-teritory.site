@extends('layouts.app')

@section('title','Маркетинговая статистика')
@section('header','Маркетинговая статистика')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.marketing-statistic') }}
        <hr>
        <div class="row ">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-marketing-statistic></bookkeeping-marketing-statistic>
            </div>
        </div>
    </div>
@endsection
