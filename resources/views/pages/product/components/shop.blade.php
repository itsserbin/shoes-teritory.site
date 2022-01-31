<section id="shop" class="shop">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <images-slider></images-slider>
            </div>

            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="shop__product-name">
                        <div class="shop__title">{{$product->h1}}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="shop__product-code text-end">Код: {{$product->vendor_code}}
                                /{{$product->id}}</div>
                            @if($product->status == 'in stock')
                                <div class="shop__product-availability">
                                    Товар в наличии
                                </div>
                            @elseif($product->status == 'ends')
                                <div class="shop__product-availability text-warning">
                                    Заканчивается
                                </div>
                            @else
                                <div class="shop__product-availability text-danger">
                                    Нет в наличии
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <add-to-cart
                    availability="{{$product->status}}"
                    h1="{{$product->h1}}"
                    category="{{count($product->categories) ? $product->categories[0]->title : null}}"
                    discount-price="{{ $product->discount_price }}"
                    price="{{ $product->price }}"
                    size-table="{{$product->size_table}}"
                    id="{{$product->id}}"
                    colors="{{ json_encode($product->colors) }}"
                    xs="{{json_encode($product->xs)}}"
                    s="{{json_encode($product->s)}}"
                    m="{{json_encode($product->m)}}"
                    l="{{json_encode($product->l)}}"
                    xl="{{json_encode($product->xl)}}"
                    xxl="{{json_encode($product->xxl)}}"
                    xxxl="{{json_encode($product->xxxl)}}"
                    xxxxl="{{json_encode($product->xxxxl)}}"
                    xxxxxl="{{json_encode($product->xxxxxl)}}"
                ></add-to-cart>

                <div class="row mb-3">
                    <delivery-and-return-accordion></delivery-and-return-accordion>
                </div>
                <div class="mt-2">
                    @if(isset($product->content))
                        <div class="shop__description-title block-title">Описание</div>
                        <div class="shop__description">
                            {!! $product->content !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($product->characteristics))
                <div class="col-12 col-md-6">
                    <div id="specifications" class="shop__specifications-title block-title">Характеристики</div>
                    <div class="characteristics-table">
                        {!! $product->characteristics !!}
                    </div>
                </div>
            @endif
            <div class="col-12 col-md-6">
                <product-reviews id="{{$product->id}}"></product-reviews>
            </div>
        </div>
    </div>
</section>
