@extends('layouts.app')

@section('title','Редактирование расхода')
@section('header','Редактирование расхода')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.costs.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <bookkeeping-costs-edit></bookkeeping-costs-edit>
            </div>
        </div>
    </div>
@endsection
