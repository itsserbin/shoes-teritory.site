@extends('layouts.app')
@section('title','Баннера')
@section('header','Баннера')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('options.banners') }}
        <hr>
        <div class="row">
            <div class="col-12 col-md-2">
                @include('admin.options.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <banners-list
                    destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
                    published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
                    not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
                ></banners-list>
            </div>
        </div>
    </div>
@endsection
