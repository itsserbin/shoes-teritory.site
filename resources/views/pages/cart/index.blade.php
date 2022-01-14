@extends('layouts.master')

@section('title','Ваша корзина')

@section('content')
    <section class="cart">
        <div class="container">
            <cart-component></cart-component>
        </div>
    </section>
@endsection
