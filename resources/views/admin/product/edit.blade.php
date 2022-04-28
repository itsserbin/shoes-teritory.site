@extends('layouts.app')
@section('title','Редактирование товара')
@section('header','Редактирование товара')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('products.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <edit-product
                    in-stock-availability="{{\App\Models\Enum\ProductAvailability::IN_STOCK}}"
                    out-of-stock-availability="{{\App\Models\Enum\ProductAvailability::OUT_OF_STOCK}}"
                    ends-availability="{{\App\Models\Enum\ProductAvailability::ENDS}}"
                ></edit-product>
            </div>
        </div>
    </div>
@endsection
