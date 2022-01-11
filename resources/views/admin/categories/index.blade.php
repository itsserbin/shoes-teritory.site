@extends('layouts.app')
@section('title','Категории')
@section('header','Категории')

@section('content')
    <categories-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
        published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
        not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
    ></categories-list>
@endsection
