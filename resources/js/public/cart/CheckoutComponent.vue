<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="row" v-if="!isLoading">
            <div class="col-12 col-md-6 mb-3">
                <div class="ordering-item">
                    <div class="ordering-item__title">
                        <h3>{{ textPersonalData }}</h3>
                    </div>
                    <div class="data-list">
                        <div class="input data-list__item">
                            <label> {{ textName }}<span class="required">*</span>
                                <input type="text" v-model="order.name" :placeholder="textEnterName">
                                <input-invalid-feedback v-if="errors.name"
                                                        :errors="errors.name"
                                ></input-invalid-feedback>
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label>{{ textSurname }}
                                <input type="text" v-model="order.last_name" :placeholder="textEnterSurname">
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label>{{ textPhone }} <span class="required">*</span>
                                <the-mask type="tel"
                                          class="phone"
                                          placeholder="+38 (0"
                                          v-model="order.phone"
                                          :mask="'+38 (0##) ###-##-##'"
                                />
                                <input-invalid-feedback v-if="errors.phone"
                                                        :errors="errors.phone"
                                ></input-invalid-feedback>
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label>{{ textEmail }}
                                <input type="email" v-model="order.email" :placeholder="textEnterEmail">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="ordering-item payment-delivery">
                    <div class="ordering-item__title">
                        <h3>{{ textDelivery }}</h3>
                    </div>
                    <div class="data-list">
                        <div class="input data-list__item">
                            <label>{{ textCity }}<span class="required">*</span>
                                <input type="text" v-model="order.city" :placeholder="textEnterCity">
                                <input-invalid-feedback v-if="errors.city"
                                                        :errors="errors.city"
                                ></input-invalid-feedback>
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label>{{ textPostalOfficeNovaPoshta }}<span class="required">*</span>
                                <input type="text" v-model="order.postal_office"
                                       :placeholder="textEnterPostalOfficeNovaPoshta">
                                <input-invalid-feedback v-if="errors.postal_office"
                                                        :errors="errors.postal_office"
                                ></input-invalid-feedback>
                            </label>
                        </div>
                    </div>
                </div>

                <!--                <div class="ordering-item payment-delivery">-->
                <!--                    <div class="ordering-item__title">-->
                <!--                        <h3>Оплата</h3>-->
                <!--                    </div>-->
                <!--                    <div class="data-list w100 mb-4">-->
                <!--                        <div-->
                <!--                            class="data-list__item d-sm-flex align-items-sm-center justify-content-sm-between radio-btn">-->
                <!--                            <label class="me-sm-2">-->
                <!--                                <input type="radio"-->
                <!--                                       v-model="order.payment_method"-->
                <!--                                       name="payment"-->
                <!--                                       value="Cash"-->
                <!--                                >-->
                <!--                                <span></span>-->
                <!--                                <p class="a-text">Наличные</p>-->
                <!--                            </label>-->
                <!--                        </div>-->
                <!--                        <div-->
                <!--                            class="data-list__item d-sm-flex align-items-sm-center justify-content-sm-between radio-btn">-->
                <!--                            <label class="me-sm-2">-->
                <!--                                <input type="radio"-->
                <!--                                       v-model="order.payment_method"-->
                <!--                                       name="payment"-->
                <!--                                       value="Card"-->
                <!--                                >-->
                <!--                                <span></span>-->
                <!--                                <p class="a-text">Оплата картой</p>-->
                <!--                            </label>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->


                <div class="textarea">
                    <label>{{ textComment }}
                        <textarea v-model="order.comment" :placeholder="textEnterComment"></textarea>
                    </label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="ordering-right__inner">
                    <div class="ordering-cart">
                        <div class="ordering-item__title">
                            <h3>{{ textOrder }}</h3>
                        </div>
                        <div class="ordering-cart__list">
                            <div class="ordering-cart__item" v-for="item in cart.list" :key="item.id">
                                <div class="img">
                                    <div class="img-inner">
                                        <img
                                            :src="item.image ? '/storage/products/350/' + item.image : '/images/no-image.png'"
                                            :alt="item.name.ua" v-if="lang === 'ua'">

                                        <img
                                            :src="item.image ? '/storage/products/350/' + item.image : '/images/no-image.png'"
                                            :alt="item.name.ru" v-if="lang === 'ru'">
                                    </div>
                                </div>
                                <div class="line"></div>
                                <div class="title" v-if="lang === 'ua'">{{ item.name.ua }}</div>
                                <div class="title" v-if="lang === 'ru'">{{ item.name.ru }}</div>
                                <div class="color-size">
                                    <div v-if="item.color.length || item.size.length">
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
                                <div class="ordering-cart__count"> x<span class="count">{{ item.count }}</span></div>
                                <div class="product-card__price">
                                    <div class="price">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment">
                        <div class="payment-top">
                            <div class="sum">
                                <div class="item discount" v-if="cart.price_without_discount !== 0">
                                    <div class="label">{{ textCartPriceWithoutDiscount }}</div>
                                    <div class="value">
                                        <div class="product-card__price">
                                            <div class="price">
                                                <del>
                                                    <span class="amount price-old"> {{ cart.price_without_discount }} грн. </span>
                                                </del>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">{{ textCartTotalPrice }}</div>
                                    <div class="value">
                                        <div class="product-card__price">
                                            <div class="price total">{{ cart.totalPrice }} грн.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons">
                                <a href="javascript:" class="button-checkout"
                                   @click.prevent="sendOrder">{{ textSendOrder }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {TheMask} from 'vue-the-mask'

import destroyIcon from '../../components/icons/DestroyIcon';

export default {
    components: {
        TheMask,
        'destroy-icon': destroyIcon
    },
    data() {
        return {
            host: window.location.origin + '/',
            isLoading: false,
            cart: this.$store.state,
            errors: [],
            order: {
                name: null,
                last_name: null,
                email: null,
                comment: null,
                phone: null,
                city: null,
                postal_office: null,
                payment_method: null,
            },
            contentIds: [],
            fbInitiateCheckout: true,
        }
    },
    updated() {
        const self = this;
        if (self.fbInitiateCheckout) {

            self.cart.list.forEach((item) => {
                self.contentIds.push(item.id);
            });

            fbq('track', 'InitiateCheckout', {
                "value": self.cart.totalPrice,
                "currency": "UAH",
                "num_items": self.cart.totalCount,
                "content_ids": self.contentIds,
                "content_type": "product"
            });

            self.fbInitiateCheckout = false;
        }
    },
    props: {
        lang: String,
        textPersonalData: String,
        textEnterName: String,
        textName: String,
        textEnterSurname: String,
        textSurname: String,
        textPhone: String,
        textEnterPhone: String,
        textEnterEmail: String,
        textEmail: String,
        textDelivery: String,
        textEnterCity: String,
        textCity: String,
        textPostalOfficeNovaPoshta: String,
        textEnterPostalOfficeNovaPoshta: String,
        textEnterComment: String,
        textComment: String,
        textOrder: String,
        textCartPriceWithoutDiscount: String,
        textCartTotalPrice: String,
        textSendOrder: String,
        textSuccessSendOrder: String,
        textErrorDescription: String,
        textError: String,
    },
    methods: {
        removeFromCart(id) {
            axios.delete('/api/v1/cart/delete/' + id)
                .then(() => this.$store.commit('loadCart'))
                .catch((response) => console.log(response));
        },
        sendOrder() {
            this.isLoading = true;
            this.errors = [];
            axios.post('/api/v1/order/create', this.order)
                .then(() => {
                    fbq('track', 'Purchase', {
                        "value": this.cart.totalPrice,
                        "currency": "UAH",
                        "content_type": "product",
                        "num_items": this.cart.totalCount,
                        "content_ids": this.contentIds
                    });
                    this.isLoading = false;
                    this.$swal({
                        title: this.textSuccessSendOrder,
                        icon: 'success',
                    });
                    setTimeout(window.location.href = '/', 3000);
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    this.isLoading = false;
                    this.$swal({
                        title: this.textError,
                        text: this.textErrorDescription,
                        icon: 'error',
                    });
                });
        }
    }
}
</script>
