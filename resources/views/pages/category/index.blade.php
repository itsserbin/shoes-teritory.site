@extends('layouts.master')

@section('title',$category->title)

@section('content')
    @component('components.breadcrumbs')
        @slot('active'){{$category->title}}@endslot
    @endcomponent

    <div class="container">
        <div class="row">
            <category
                category-id="{{$category->id}}"
                category-title="{{$category->title}}"
                category-slug="{{$category->slug}}"
            ></category>
        </div>
    </div>
@endsection
