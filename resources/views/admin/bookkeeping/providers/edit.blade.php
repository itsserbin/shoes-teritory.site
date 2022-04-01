@extends('layouts.app')
@section('title','Редактирование поставщика')
@section('header','Редактирование поставщика')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('bookkeeping.providers.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.bookkeeping.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-provider></edit-provider>
            </div>
        </div>
    </div>
@endsection
