@extends('layouts.app')
@section('title','Карточка клиента')
@section('header','Карточка клиента')

@section('content')
    <edit-client
        new-status="{{\App\Models\Enum\ClientStatus::NEW_STATUS}}"
        experienced-status="{{\App\Models\Enum\ClientStatus::EXPERIENCED_STATUS}}"
        return-status="{{\App\Models\Enum\ClientStatus::RETURN_STATUS}}"
        top-status="{{\App\Models\Enum\ClientStatus::TOP_STATUS}}"
        black-list-status="{{\App\Models\Enum\ClientStatus::BLACK_LIST_STATUS}}"
    ></edit-client>
@endsection
