@extends('layouts.app')
@section('title','Редактирование баннер')
@section('header','Редактирование баннер')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.banners.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-banner></edit-banner>
            </div>
        </div>
    </div>
@endsection
