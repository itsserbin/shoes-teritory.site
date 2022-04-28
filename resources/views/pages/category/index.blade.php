@extends('layouts.master')

@section('title',app()->getLocale() == 'ua' ? $category->meta_title['ua'] : $category->meta_title['ru'])
@section('description',app()->getLocale() == 'ua' ? $category->meta_description['ua'] : $category->meta_description['ru'])

@section('content')
    @component('components.breadcrumbs')
        @slot('active'){{app()->getLocale() == 'ua' ? $category->title['ua'] : $category->title['ru']}}@endslot
    @endcomponent

    <div class="container">
        <div class="row">
            <category
                category-id="{{$category->id}}"
                category-title="{{app()->getLocale() == 'ua' ? $category->title['ua'] : $category->title['ru']}}"
                category-slug="{{$category->slug}}"
                text-load-more="@lang('home.text_load_more')"
                text-go-to-product-card="@lang('home.text_go_to_product_card')"
                lang="{{app()->getLocale()}}"
                product-route="{{route('product')}}"
            ></category>
        </div>
    </div>
@endsection
