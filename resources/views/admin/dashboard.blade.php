@extends('layouts.app')
@section('header')Добро пожаловать, {{auth()->user()->name}} :)@endsection
@section('title','Welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <admin-dashboard></admin-dashboard>

            </div>
        </div>
        <div class="row">
            <bookkeeping-daily-statistics
                administrator-role="{{json_encode(auth()->check() && auth()->user()->hasRole('administrator'))}}"
                admin-permission="{{json_encode(Gate::allows('admin'))}}"
            ></bookkeeping-daily-statistics>
        </div>
    </div>
@endsection
