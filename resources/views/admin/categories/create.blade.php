@extends('layouts.app')
@section('title','Создание категории')
@section('header','Создание категории')

@section('content')
<div class="container">
    {{ Breadcrumbs::render('categories.create') }}
    <hr>
    <div class="row">
        <div class="col-12">
            <category-create user-name="{{\Illuminate\Support\Facades\Auth::user()->name}}"></category-create>
        </div>
    </div>
</div>
@endsection
