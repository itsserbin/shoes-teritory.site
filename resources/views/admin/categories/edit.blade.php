@extends('layouts.app')
@section('title','Редактирование категории')
@section('header','Редактирование категории')

@section('content')
    <category-edit user-name="{{\Illuminate\Support\Facades\Auth::user()->name}}"></category-edit>
@endsection
