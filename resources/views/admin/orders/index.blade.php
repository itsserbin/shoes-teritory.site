@extends('layouts.app')
@section('title', 'Заказы')
@section('header', 'Заказы')


@section('content')
    <orders-list
        destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"
        status-new="{{\App\Models\Enum\OrderStatus::STATUS_NEW}}"
        status-at-the-post-office="{{\App\Models\Enum\OrderStatus::STATUS_AT_THE_POST_OFFICE}}"
        status-awaiting-dispatch="{{\App\Models\Enum\OrderStatus::STATUS_AWAITING_DISPATCH}}"
        status-awaiting-prepayment="{{\App\Models\Enum\OrderStatus::STATUS_AWAITING_PREPAYMENT}}"
        status-canceled="{{\App\Models\Enum\OrderStatus::STATUS_CANCELED}}"
        status-done="{{\App\Models\Enum\OrderStatus::STATUS_DONE}}"
        status-on-the-road="{{\App\Models\Enum\OrderStatus::STATUS_ON_THE_ROAD}}"
        status-processed="{{\App\Models\Enum\OrderStatus::STATUS_PROCESSED}}"
        status-return="{{\App\Models\Enum\OrderStatus::STATUS_RETURN}}"
        status-transferred-to-supplier="{{\App\Models\Enum\OrderStatus::STATUS_TRANSFERRED_TO_SUPPLIER}}"
    ></orders-list>
@endsection
