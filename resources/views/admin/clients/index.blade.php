@extends('layouts.app')
@section('title', 'Клиенты')
@section('header', 'Клиенты')

@section('content')
    <clients-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
    ></clients-list>
@endsection
