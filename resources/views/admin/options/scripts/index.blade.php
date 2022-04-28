@extends('layouts.app')
@section('title', 'Вставка CSS/JS')
@section('header', 'Вставка CSS/JS')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <scripts-options-list></scripts-options-list>
            </div>
        </div>
    </div>
@endsection
