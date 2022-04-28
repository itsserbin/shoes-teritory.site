<template>
    <div>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="cart-item" v-for="item in cart.list" :key="item.id">
                    <div class="cart-item__inner">
                        <div class="cart-item__color" v-if="item.color.length || item.size.length">
                            <div>
                                <div class="color"
                                     v-for="color in item.color"
                                     v-if="item.color.length"
                                >{{ color }}
                                </div>
                                <div class="size"
                                     v-if="item.size.length"
                                     v-for="size in item.size"
                                >{{ size }}
                                </div>
                            </div>
                        </div>
                        <div class="delete-cart" @click="removeFromCart(item.id)">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.0575 9.00002L14.7825 4.28252C14.9237 4.14129 15.003 3.94974 15.003 3.75002C15.003 3.55029 14.9237 3.35874 14.7825 3.21752C14.6412 3.07629 14.4497 2.99695 14.25 2.99695C14.0502 2.99695 13.8587 3.07629 13.7175 3.21752L8.99995 7.94252L4.28245 3.21752C4.14123 3.07629 3.94968 2.99695 3.74995 2.99695C3.55023 2.99695 3.35868 3.07629 3.21745 3.21752C3.07623 3.35874 2.99689 3.55029 2.99689 3.75002C2.99689 3.94974 3.07623 4.14129 3.21745 4.28252L7.94245 9.00002L3.21745 13.7175C3.14716 13.7872 3.09136 13.8702 3.05329 13.9616C3.01521 14.053 2.99561 14.151 2.99561 14.25C2.99561 14.349 3.01521 14.4471 3.05329 14.5384C3.09136 14.6298 3.14716 14.7128 3.21745 14.7825C3.28718 14.8528 3.37013 14.9086 3.46152 14.9467C3.55292 14.9848 3.65095 15.0044 3.74995 15.0044C3.84896 15.0044 3.94699 14.9848 4.03839 14.9467C4.12978 14.9086 4.21273 14.8528 4.28245 14.7825L8.99995 10.0575L13.7175 14.7825C13.7872 14.8528 13.8701 14.9086 13.9615 14.9467C14.0529 14.9848 14.1509 15.0044 14.25 15.0044C14.349 15.0044 14.447 14.9848 14.5384 14.9467C14.6298 14.9086 14.7127 14.8528 14.7825 14.7825C14.8527 14.7128 14.9085 14.6298 14.9466 14.5384C14.9847 14.4471 15.0043 14.349 15.0043 14.25C15.0043 14.151 14.9847 14.053 14.9466 13.9616C14.9085 13.8702 14.8527 13.7872 14.7825 13.7175L10.0575 9.00002Z"
                                    fill="#878787"></path>
                            </svg>
                        </div>
                        <div class="cart-item__img">
                            <div class="img">
                                <a :href="productRoute + '/' + item.id">
                                    <img
                                        :src="item.image ? '/storage/products/350/' + item.image : '/images/no-image.png'"
                                        :alt="lang === 'ua' ? item.name.ua : (lang === 'ru' ? item.name.ru : null)">
                                </a>

                            </div>
                        </div>
                        <a :href="'/product/' + item.id" class="cart-item__title text-danger">
                            <div>{{ lang === 'ua' ? item.name.ua : (lang === 'ru' ? item.name.ru : null) }}</div>
                        </a>
                        <div class="cart-item__bottom">
                            <div class="product-card__price">
                                <div class="price" v-if="item.discount_price !== 0">
                                    <del>
                                        <span class="amount price-old">{{ item.price }}
                                            <span class="icon-currency"
                                                  style="font-size: 0.875rem">грн.
                                            </span>
                                        </span>
                                    </del>
                                    <ins>
                                        <span class="amount price-sale">
                                            {{ item.discount_price }}
                                            <span class="icon-currency" style="font-size: 0.875rem">
                                                грн.
                                            </span>
                                        </span>
                                    </ins>
                                </div>

                                <div class="price" v-if="item.discount_price === 0">
                                    <div style="display: flex;align-items: flex-end;">
                                        {{ item.price }}&nbsp;
                                        <span class="icon-currency" style="font-size: 0.875rem">грн.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="qty-block">
                                <div class="qty-btn" @click="updateDecrementCount(item.id)">
                                    <span class="minus">-</span>
                                </div>
                                <input type="text" v-model="item.count">
                                <div class="qty-btn" @click="updateIncrementCount(item.id)">
                                    <span class="plus">+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="cart-item__right row mb-3">
                    <form class="promocode mb-3" v-if="cart.promo_code">
                        <label class="promocode__label">{{ textYourPromoCode }}
                            <input class="promocode__input mx-3"
                                   type="text"
                                   placeholder="XXX-XXX-XXX"
                                   v-model="cart.promo_code"
                                   disabled
                            >
                        </label>
                        <a href="javascript:"
                           class="promocode__button"
                           @click="deactivatePromoCode"
                        >{{ textCartDeactivatePromocode }}</a>
                    </form>
                    <form class="promocode mb-3" v-else>
                        <label class="promocode__label">{{ textPromoCode }}
                            <input class="promocode__input mx-3"
                                   type="text"
                                   placeholder="XXX-XXX-XXX"
                                   v-model="promo_code"
                            >
                        </label>
                        <a href="javascript:"
                           class="promocode__button"
                           @click="activatePromoCode"
                        >{{ textCartActivatePromocode }}</a>
                    </form>

                    <div class="payment">
                        <div class="sum">
                            <div class="item">
                                <div class="label">{{ textCartTotalCount }}</div>
                                <div class="value">
                                    <div class="total">
                                        <div class="price total">{{ cart.totalCount }}</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="item discount" v-if="cart.price_without_discount !== 0">
                                <div class="label">{{ textCartPriceWithoutDiscount }}</div>
                                <div class="value">
                                    <div class="product-card__price">
                                        <div class="price">
                                            <del>
                                                <span class="amount price-old">{{
                                                        cart.price_without_discount
                                                    }} грн.</span>
                                            </del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="label">{{ textCartTotalPrice }}</div>
                                <div class="value">
                                    <div class="total">
                                        <div class="price total">{{ cart.totalPrice }} грн.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <a :href="checkoutRoute" class="payment-btn">{{ textGoToCheckout }}</a>
                        </div>
                    </div>


                    <div class="additions">
                        <h3 class="additions-title">{{ textCartAdditionalProducts }}</h3>
                        <div class="additions-list">
                            <div class="additions-item" v-for="recommendProduct in recommendProducts"
                                 :key="recommendProduct.id">
                                <div class="additions-item__inner">
                                    <div class="additions-item__left">
                                        <div class="img">
                                            <a :href="productRoute + '/' + recommendProduct.id">
                                                <img :src="'/storage/products/350/' + recommendProduct.preview"
                                                     :alt="lang === 'ua' ? recommendProduct.h1.ua : (lang === 'ru' ? recommendProduct.h1.ru : null)">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="additions-item__desc">
                                        <div class="left">
                                            <a :href="productRoute + '/' + recommendProduct.id">
                                                <div class="name">
                                                    {{lang === 'ua' ? recommendProduct.h1.ua : (lang === 'ru' ? recommendProduct.h1.ru : null) }}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="right">
                                            <div class="price">{{
                                                    recommendProduct.discount_price ?
                                                        recommendProduct.discount_price : recommendProduct.price
                                                }}
                                                <span class="icon-currency"
                                                      style="font-size: 0.875rem;"> грн. </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="additions-item__right">
                                        <div class="plus-btn" @click="addToCart(recommendProduct.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'CartComponent',
    data() {
        return {
            promo_code: null,
            isLoading: false,
            cart: this.$store.state,
            errors: [],
            recommendProducts: []
        }
    },
    mounted() {
        axios.get('/api/v1/product/recommend-products')
            .then(({data}) => this.recommendProducts = data.result.data)
            .catch((response) => console.log(response));
    },
    props: {
        lang: String,
        textPromoCode: String,
        textYourPromoCode: String,
        textCartTotalCount: String,
        textCartPriceWithoutDiscount: String,
        textCartTotalPrice: String,
        textGoToCheckout: String,
        textCartAdditionalProducts: String,
        textCartDeactivatePromocode: String,
        textCartActivatePromocode: String,
        productRoute: String,
        checkoutRoute: String
    },
    methods: {
        addToCart(id) {
            axios.post('/api/v1/cart/add', {
                count: 1,
                size: [],
                color: [],
                item_id: id,
            })
                .then(({data}) => {
                    this.$store.commit('loadCart');
                    this.$swal({
                        title: 'Добавлено!',
                        text: 'Товар в корзине :)',
                        icon: 'success',

                    })
                })
                .catch(() => {
                    this.$swal({
                        title: 'Ошибка!',
                        text: 'Что то сломалось :(',
                        icon: 'error',
                    });
                });
        },
        removeFromCart(id) {
            axios.delete('/api/v1/cart/delete/' + id)
                .then(() => this.cartListSuccessResponse())
                .catch((response) => this.cartListErrorResponse(response));
        },
        cartListSuccessResponse() {
            this.$store.commit('loadCart');
        },
        cartListErrorResponse(response) {
            console.log(response);
        },
        updateDecrementCount(id) {
            axios.post('/api/v1/cart/update-decrement/' + id)
                .then(() => this.cartListSuccessResponse())
                .catch((response) => this.cartListErrorResponse(response));
        },
        updateIncrementCount(id) {
            axios.post('/api/v1/cart/update-increment/' + id)
                .then(() => this.cartListSuccessResponse())
                .catch((response) => this.cartListErrorResponse(response));
        },
        activatePromoCode() {
            axios.post('/api/v1/cart/promo-code/activate', {
                promo_code: this.promo_code
            })
                .then(({data}) => {
                    if (data.result) {
                        this.$swal({
                            'title': 'Промо-код активирован!',
                            'icon': 'success'
                        })
                        this.cartListSuccessResponse();
                    } else {
                        this.$swal({
                            'title': 'Произошла ошибка :(',
                            'text': 'Возможно, промо-код введен некорректно, или же истек срок действия',
                            'icon': 'error'
                        })
                    }
                })
                .catch((response) => console.log(response));
        },
        deactivatePromoCode() {
            this.promo_code = null;
            axios.post('/api/v1/cart/promo-code/deactivate', {
                promo_code: this.cart.promo_code
            })
                .then(() => {
                    this.$swal({
                        'title': 'Промо-код деактивирован!',
                        'icon': 'success'
                    })
                    this.cartListSuccessResponse();
                })
                .catch((response) => console.log(response));
        }
    }
}
</script>
