@extends('layouts.app')
@section('title', 'Изменение преимущества')
@section('header', 'Изменение преимущества')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.advantages.edit') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <edit-advantage></edit-advantage>
            </div>
        </div>
    </div>
@endsection
