@extends('layouts.app')
@section('title','Категории')
@section('header','Категории')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('categories') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <categories-list
                    destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
                    published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
                    not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
                ></categories-list>
            </div>
        </div>
    </div>
@endsection
