@extends('layouts.master')

@section('title',app()->getLocale() == 'ua' ? $page->meta_title['ua'] : $page->meta_title['ru'] )

@section('content')
    @component('components.breadcrumbs')
        @slot('active'){{app()->getLocale() == 'ua' ? $page->heading['ua'] : $page->heading['ru']}}@endslot
    @endcomponent
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! app()->getLocale() == 'ua' ? $page->content['ua'] : $page->content['ru'] !!}
                </div>
            </div>
        </div>
    </section>
@endsection
