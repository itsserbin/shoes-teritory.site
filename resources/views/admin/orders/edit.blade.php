@extends('layouts.app')
@section('title','Детали заказа')
@section('header','Детали заказа')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('orders.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <order-edit
                    user-name="{{\Illuminate\Support\Facades\Auth::user()->name}}"
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
                ></order-edit>
            </div>
        </div>
    </div>
@endsection
