@extends('layouts.app')
@section('title', 'Редактирование FAQ')
@section('header', 'Редактирование FAQ')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.faq.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-faq></edit-faq>
            </div>
        </div>
    </div>
@endsection
