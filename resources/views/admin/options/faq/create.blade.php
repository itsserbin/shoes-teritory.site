@extends('layouts.app')
@section('title', 'Добавление FAQ')
@section('header', 'Добавление FAQ')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.faq.create') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <create-faq></create-faq>
            </div>
        </div>
    </div>
@endsection
