@extends('layouts.app')
@section('header')Добро пожаловать, {{auth()->user()->name}} :)@endsection
@section('title','Welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <admin-dashboard></admin-dashboard>
                <hr>
            </div>
        </div>
        <div class="row">
            <bookkeeping-orders-statistics></bookkeeping-orders-statistics>
        </div>
    </div>
@endsection
