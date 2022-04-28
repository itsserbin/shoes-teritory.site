@extends('layouts.app')
@section('title','Редактирование категории')
@section('header','Редактирование категории')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('categories.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <category-edit user-name="{{\Illuminate\Support\Facades\Auth::user()->name}}"></category-edit>
            </div>
        </div>
    </div>
@endsection
