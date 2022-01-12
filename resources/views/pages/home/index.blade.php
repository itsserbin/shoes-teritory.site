@extends('layouts.master')
@section('title')Магазин женского нижнего белья и пляжной одежды@endsection
@section('description')Женские купальники премиум качества с доставкой по всей Украине ✓ Лучшие коллекции 2021 года ✓ Доступные цены @endsection

@section('content')
    <section class="product-list card pt-3">
        <div class="container">
            <div class="product-list__title">Трендовое женское нижнее белье и пляжная одежда 2022 года</div>
            <categories-grid></categories-grid>
            <div class="product-list__title">Самые продаваемые</div>
            <best-selling-products></best-selling-products>
            <div class="mt-5">
                <div class="product-list__title">Все товары</div>
                <all-products></all-products>
            </div>
        </div>
    </section>
    @include('pages.product.components.advantages')
    <all-reviews-component></all-reviews-component>
@endsection
