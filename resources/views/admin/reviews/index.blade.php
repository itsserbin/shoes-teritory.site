@extends('layouts.app')
@section('title', 'Отзывы')
@section('header', 'Отзывы')

@section('content')
    <reviews-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
        published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
        not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
    ></reviews-list>
@endsection
