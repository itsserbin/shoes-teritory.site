@extends('layouts.app')
@section('title','Промо-коды')
@section('header','Промо-коды')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.promo-codes') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <promo-codes-list></promo-codes-list>
            </div>
        </div>
    </div>
@endsection
