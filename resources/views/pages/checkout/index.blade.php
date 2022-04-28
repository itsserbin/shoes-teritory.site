@extends('layouts.master')

@section('title')@lang('home.text_title_checkout')@endsection

@section('content')
    @component('components.breadcrumbs')
        @slot('active')@lang('home.text_title_checkout')@endslot
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-12">
                <checkout
                    lang="{{app()->getLocale()}}"
                    text-personal-data="@lang('home.text_personal_data')"
                    text-name="@lang('home.text_name')"
                    text-enter-name="@lang('home.text_enter_name')"
                    text-surname="@lang('home.text_surname')"
                    text-enter-surname="@lang('home.text_enter_surname')"
                    text-phone="@lang('home.text_phone')"
                    text-email="@lang('home.text_email')"
                    text-enter-email="@lang('home.text_enter_email')"
                    text-delivery="@lang('home.text_delivery')"
                    text-postal-office-nova-poshta="@lang('home.text_postal_office_nova_poshta')"
                    text-enter-postal-office-nova-poshta="@lang('home.text_enter_postal_office_nova_poshta')"
                    text-enter-comment="@lang('home.text_enter_comment')"
                    text-comment="@lang('home.text_comment')"
                    text-order="@lang('home.text_order')"
                    text-cart-price-without-discount="@lang('cart.text_cart_price_without_discount')"
                    text-cart-total-price="@lang('cart.text_cart_total_price')"
                    text-send-order="@lang('home.text_send_order')"
                    text-city="@lang('home.text_city')"
                    text-enter-city="@lang('home.text_enter_city')"
                    text-success-send-order="@lang('home.text_success_send_order')"
                    text-error-description="@lang('home.text_error_description')"
                    text-error="@lang('home.text_error')"
                ></checkout>
            </div>
        </div>
    </div>

@endsection
