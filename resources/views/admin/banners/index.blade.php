@extends('layouts.app')
@section('title','Баннера')
@section('header','Баннера')

@section('content')
    <banners-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
        published-mass-action="{{\App\Models\Enum\MassActions::PUBLISHED}}"
        not-published-mass-action="{{\App\Models\Enum\MassActions::NOT_PUBLISHED}}"
    ></banners-list>
@endsection
