@extends('layouts.master')

@section('title','Оформление заказа')

@section('content')
    @component('components.breadcrumbs')
        @slot('active')Оформление заказа@endslot
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-12">
                <checkout></checkout>
            </div>
        </div>
    </div>

@endsection
