<section id="shop" class="shop">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <images-slider></images-slider>
            </div>

            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="shop__product-name">
                        <div
                            class="shop__title">{{app()->getLocale() == 'ua' ? $product->h1['ua'] : $product->h1['ru']}}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="shop__product-code text-end">Код: {{$product->vendor_code}}
                                /{{$product->id}}</div>
                            @if($product->status == 'in stock')
                                <div class="shop__product-availability">
                                    @lang('product.text_product_in_stock')
                                </div>
                            @elseif($product->status == 'ends')
                                <div class="shop__product-availability text-warning">
                                    @lang('product.text_product_ends')
                                </div>
                            @else
                                <div class="shop__product-availability text-danger">
                                    @lang('product.text_product_out_of_stock')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <add-to-cart
                    availability="{{$product->status}}"
                    h1="{{app()->getLocale() == 'ua' ? $product->h1['ua'] : $product->h1['ru']}}"
                    @if(count($product->categories))
                    category="{{app()->getLocale() == 'ua' ? $product->categories[0]->title['ua'] : $product->categories[0]->title['ru']}}"
                    @endif
                    discount-price="{{ $product->discount_price }}"
                    price="{{ $product->price }}"
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
                    text-buy-product="@lang('product.text_buy_product')"
                    text-available-sizes="@lang('product.text_available_sizes')"
                    text-available-colors="@lang('product.text_available_colors')"
                    text-added-product-to-cart="@lang('product.text_added_product_to_cart')"
                    text-go-to-checkout="@lang('home.text_go_to_checkout')"
                    text-continue-shopping="@lang('home.text_continue_shopping')"
                    text-error="@lang('home.text_error')"
                    text-error-description="@lang('home.text_error_description')"
                ></add-to-cart>

                <div class="row mb-3">
                    <sizes-table
                        size-table="{{$product->size_table}}"
                        text-sizes-table="@lang('product.text_sizes_table')"
                    ></sizes-table>
                </div>

                <div class="row mb-3">
                    <delivery-and-return-accordion
                        lang="{{app()->getLocale()}}"
                        text-delivery-and-payment="@lang('home.text_delivery_and_payment')"
                        text-return-and-exchange="@lang('home.text_return_and_exchange')"
                        text-return-and-exchange-ua="{{$options['text_return_and_exchange_ua']->value}}"
                        text-return-and-exchange-ru="{{$options['text_return_and_exchange_ru']->value}}"
                        text-delivery-and-payment-ru="{{$options['text_delivery_and_payment_ru']->value}}"
                        text-delivery-and-payment-ua="{{$options['text_delivery_and_payment_ua']->value}}"
                    ></delivery-and-return-accordion>
                </div>
                <div class="mt-2">
                    @if(isset($product->content))
                        <div class="shop__description-title block-title">@lang('product.text_product_description')</div>
                        <div class="shop__description">
                            {!! app()->getLocale() == 'ua' ? $product->content['ua'] : $product->content['ru'] !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($product->characteristics))
                <div class="col-12 col-md-6">
                    <div id="specifications"
                         class="shop__specifications-title block-title"
                    >@lang('product.text_product_characteristics')</div>
                    <div class="characteristics-table">
                        {!! app()->getLocale() == 'ua' ? $product->characteristics['ua'] : $product->characteristics['ru'] !!}
                    </div>
                </div>
            @endif
            <div class="col-12 col-md-6">
                <product-reviews
                    id="{{$product->id}}"
                    text-product-reviews="@lang('product.text_product_reviews')"
                    text-no-reviews="@lang('home.text_no_reviews')"
                    text-give-review="@lang('product.text_give_review')"
                    text-enter-name="@lang('home.text_enter_name')"
                    text-enter-review="@lang('home.text_enter_review')"
                ></product-reviews>
            </div>
        </div>
    </div>
</section>
