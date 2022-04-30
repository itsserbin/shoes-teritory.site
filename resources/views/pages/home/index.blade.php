@extends('layouts.master')

@if($options['meta_title_ua'] || $options['meta_title_ru'])
@section('title'){{ app()->getLocale() == 'ua' ? $options['meta_title_ua']->value : $options['meta_title_ru']->value }}@endsection
@endif

@if($options['meta_description_ua'] || $options['meta_description_ru'])
@section('description'){{ app()->getLocale() == 'ua' ? $options['meta_description_ua']->value : $options['meta_description_ru']->value }}@endsection
@endif
@section('content')
    <section class="product-list card pt-3">
        <div class="container">
            <main-banners lang="{{app()->getLocale()}}"></main-banners>
            <div class="product-list__title">@lang('home.text_heading_home_page')</div>
            <categories-grid
                lang="{{app()->getLocale()}}"
                categories-route="{{route('category')}}"
            ></categories-grid>
            <div class="product-list__title">@lang('home.text_best_selling')</div>
            <best-selling-products-home
                lang="{{app()->getLocale()}}"
                text-go-to-product-card="@lang('home.text_go_to_product_card')"
                text-load-more="@lang('home.text_load_more')"
                product-route="{{route('product')}}"
            ></best-selling-products-home>
            <div class="mt-5">
                <div class="product-list__title">@lang('home.text_latest_products')</div>
                <index-new-products
                    lang="{{app()->getLocale()}}"
                    text-load-more="@lang('home.text_load_more')"
                    text-go-to-product-card="@lang('home.text_go_to_product_card')"
                    product-route="{{route('product')}}"
                ></index-new-products>
            </div>
            <div class="mt-5">
                <div class="product-list__title">@lang('home.text_all_products')</div>
                <all-products
                    lang="{{app()->getLocale()}}"
                    text-load-more="@lang('home.text_load_more')"
                    text-go-to-product-card="@lang('home.text_go_to_product_card')"
                    product-route="{{route('product')}}"
                ></all-products>
            </div>
        </div>
    </section>
    @include('components.advantages')
    <all-reviews-component
        text-reviews="@lang('home.text_reviews')"
        text-no-reviews="@lang('home.text_no_reviews')"
    ></all-reviews-component>
@endsection
