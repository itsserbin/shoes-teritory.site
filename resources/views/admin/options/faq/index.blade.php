@extends('layouts.app')
@section('title', 'Настройка FAQ')
@section('header', 'Настройка FAQ')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.faq') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <faq-list></faq-list>
            </div>
        </div>
    </div>
@endsection
