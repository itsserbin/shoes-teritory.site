@extends('layouts.app')
@section('title','Создание категории')
@section('header','Создание категории')

@section('content')
    <category-create user-name="{{\Illuminate\Support\Facades\Auth::user()->name}}"></category-create>
@endsection
