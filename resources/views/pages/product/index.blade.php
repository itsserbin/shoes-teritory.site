@extends('layouts.master')

@section('head')
    <link rel="stylesheet" href="{{asset('css/product/app.css')}}">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{app()->getLocale() == 'ua' ? $product->h1['ua'] : $product->h1['ru']}}",
      "image": "{{asset($product->preview)}}",
      "description": "{{app()->getLocale() == 'ua' ? $product->description['ua'] : $product->description['ru']}}",
      "sku": "{{$product->vendor_code}}",
      "mpn": "{{$product->id}}",
      @if($options['brand'])
      "brand": {
        "@type": "Brand",
        "name": {{$options['brand']['value']}}
        },
        @endif

        "review": [
        @foreach($product->Reviews as $review_item)
            @if($loop->last)
                {
                "@type": "Review",
                "reviewRating": {
                  "@type": "Rating",
                  "ratingValue": "5"
                },

                "author": {
                  "@type": "Person",
                  "name": "{{$review_item->name}}"
                    },
                     "reviewBody": "{!! $review_item->comment !!}"
                    }
            @else
                {
                "@type": "Review",
                "reviewRating": {
                  "@type": "Rating",
                  "ratingValue": "5"
                },

                "author": {
                  "@type": "Person",
                  "name": "{{$review_item->name}}"
      },
        "reviewBody": "{!! $review_item->comment !!}"
      },
      @endif
        @endforeach
        ],

        "offers": {
          "@type": "Offer",
          "url": "{{route('product',$product->id)}}",
        "priceCurrency": "UAH",
        "price": "{{$product->discount_price ? : $product->price}}",
        "priceValidUntil": "{{Carbon::now()->addYear()->format('c')}}",
        "itemCondition": "https://schema.org/UsedCondition",
        "availability": "https://schema.org/InStock"
      },

      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5/5",
        "ratingCount": "{{$product->Reviews->count()}}"
      }
    }

    </script>

@endsection

@section('title'){{app()->getLocale() == 'ua' ? $product->title['ua'] : $product->title['ru']}}@endsection
@section('description'){{app()->getLocale() == 'ua' ? $product->description['ua'] : $product->description['ru']}}@endsection

@section('content')
    @component('components.breadcrumbs')
        @slot('active')
            @if(isset($product->categories[0]['title']))
                {{app()->getLocale() == 'ua' ? $product->categories[0]['title']['ua'] : $product->categories[0]['title']['ru']}}
            @else
                Без категории
            @endif
        @endslot
        @slot('active_link')
            @if(isset($product->categories[0]['slug']))
                {{route('category',$product->categories[0]['slug'])}}
            @else
                #
            @endif
        @endslot
        @slot('subsidiary'){{app()->getLocale() == 'ua' ? $product->h1['ua'] : $product->h1['ru']}}@endslot
    @endcomponent

    @include('pages.product.components.shop')
    @include('components.advantages')
    <relative-products
        id="{{$product->id}}"
        lang="{{app()->getLocale()}}"
        text-go-to-product-card="@lang('home.text_go_to_product_card')"
        text-relative-products="@lang('home.text_relative_products')"
        product-route="{{route('product')}}"
    ></relative-products>
    <best-selling-products-product
        lang="{{app()->getLocale()}}"
        text-go-to-product-card="@lang('home.text_go_to_product_card')"
        text-best-selling="@lang('home.text_best_selling')"
        product-route="{{route('product')}}"
    ></best-selling-products-product>
    <new-products
        lang="{{app()->getLocale()}}"
        text-go-to-product-card="@lang('home.text_go_to_product_card')"
        text-latest-products="@lang('home.text_latest_products')"
        product-route="{{route('product')}}"
    ></new-products>
@endsection
