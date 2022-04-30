@extends('layouts.app')
@section('title', 'Отзывы')
@section('header', 'Отзывы')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('reviews') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <reviews-list
                    destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
                    published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
                    not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
                ></reviews-list>
            </div>
        </div>
    </div>
@endsection
