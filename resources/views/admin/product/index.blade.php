@extends('layouts.app')
@section('title','Товары')
@section('header','Товары')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('products') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <products-list
                    destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
                    published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
                    not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
                ></products-list>
            </div>
        </div>
    </div>
@endsection
