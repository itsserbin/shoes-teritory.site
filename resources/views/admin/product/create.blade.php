@extends('layouts.app')
@section('title', 'Создать товар')
@section('header', 'Создать товар')

@section('content')
    <create-product
        in-stock-availability="{{\App\Models\Enum\ProductAvailability::IN_STOCK}}"
        out-of-stock-availability="{{\App\Models\Enum\ProductAvailability::OUT_OF_STOCK}}"
        ends-availability="{{\App\Models\Enum\ProductAvailability::ENDS}}"
    ></create-product>
@endsection
