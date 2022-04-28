@extends('layouts.app')
@section('title','Создание промо-кода')
@section('header','Создание промо-кода')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.promo-codes.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-promo-code></create-promo-code>
            </div>
        </div>
    </div>
@endsection
