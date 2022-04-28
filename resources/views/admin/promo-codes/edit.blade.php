@extends('layouts.app')
@section('title','Редактирование промо-кода')
@section('header','Редактирование промо-кода')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.promo-codes.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-promo-code></edit-promo-code>
            </div>
        </div>
    </div>
@endsection
