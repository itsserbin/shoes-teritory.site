@extends('layouts.app')
@section('title','Добавить поставщика')
@section('header','Добавить поставщика')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.providers.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-provider></create-provider>
            </div>
        </div>
    </div>
@endsection
