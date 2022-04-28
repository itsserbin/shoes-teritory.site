@extends('layouts.master')

@section('title')@lang('cart.text_cart_title')@endsection

@section('content')
    <section class="cart">
        <div class="container">
            <cart-component
                lang="{{app()->getLocale()}}"
                text-promo-code="@lang('cart.text_promo_code')"
                text-your-promo-code="@lang('cart.text_your_promo_code')"
                text_cart-total-count="@lang('cart.text_cart_total_count')"
                text-cart-price-without-discount="@lang('cart.text_cart_price_without_discount')"
                text-cart-total-price="@lang('cart.text_cart_total_price')"
                text-go-to-checkout="@lang('home.text_go_to_checkout')"
                text-cart-additional-products="@lang('cart.text_cart_additional_products')"
                text-cart-activate-promocode="@lang('cart.text_cart_activate_promocode')"
                text-cart-deactivate-promocode="@lang('cart.text_cart_deactivate_promocode')"
                product-route="{{route('product')}}"
                checkout-route="{{route('checkout')}}"
            ></cart-component>
        </div>
    </section>
@endsection
