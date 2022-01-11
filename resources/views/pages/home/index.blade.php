@extends('layouts.master')
@section('title')Магазин женского нижнего белья и пляжной одежды@endsection
@section('description')Женские купальники премиум качества с доставкой по всей Украине ✓ Лучшие коллекции 2021 года ✓ Доступные цены @endsection

@section('content')
    <section class="product-list card pt-3">
        <div class="container">
            <categories-grid></categories-grid>
            <div class="product-list__title">Трендовое женское нижнее белье и пляжная одежда 2022 года</div>
            <product-cards></product-cards>
        </div>
    </section>
    @include('pages.product.components.advantages')
    <all-reviews-component></all-reviews-component>
@endsection
