@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{asset('css/product/app.css')}}">
@endsection

@section('title'){{$product->title}}@endsection
@section('description'){{$product->description}}@endsection

@section('content')
@include('pages.product.components.shop')
@include('pages.product.components.relative')
@include('pages.product.components.advantages')
@include('pages.product.components.shipping-and-payment')
@endsection
