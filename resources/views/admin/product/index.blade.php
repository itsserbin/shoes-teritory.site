@extends('layouts.app')
@section('title','Товары')
@section('header','Товары')

@section('content')
    <products-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
        published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
        not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
    ></products-list>
@endsection
