@extends('layouts.app')
@section('title', 'Создать товар')
@section('header', 'Создать товар')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('products.create') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <create-product
                    in-stock-availability="{{\App\Models\Enum\ProductAvailability::IN_STOCK}}"
                    out-of-stock-availability="{{\App\Models\Enum\ProductAvailability::OUT_OF_STOCK}}"
                    ends-availability="{{\App\Models\Enum\ProductAvailability::ENDS}}"
                ></create-product>
            </div>
        </div>
    </div>
@endsection
