<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="row" v-if="!isLoading">
            <div class="col-12 col-md-6 mb-3">
                <div class="ordering-item">
                    <div class="ordering-item__title">
                        <h3>Персональные данные</h3>
                    </div>
                    <div class="data-list">
                        <div class="input data-list__item">
                            <label> Имя<span class="required">*</span>
                                <input type="text" v-model="order.name" placeholder="Введите имя">
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label> Фамилия
                                <input type="text" v-model="order.last_name" placeholder="Введите фамилию">
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label> Номер телефона <span class="required">*</span>
                                <input id="input-phone"
                                       class="phone"
                                       type="text"
                                       placeholder="+38"
                                       v-model="order.phone"
                                >
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label> Email
                                <input type="email" v-model="order.email" placeholder="Введіть вашу пошту">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="ordering-item payment-delivery">
                    <div class="ordering-item__title">
                        <h3>Доставка</h3>
                    </div>
                    <div class="data-list">
                        <div class="input data-list__item">
                            <label> Город<span class="required">*</span>
                                <input type="text" v-model="order.city" placeholder="Введите город">
                            </label>
                        </div>
                        <div class="input data-list__item">
                            <label> Отделение НоваяПочта<span class="required">*</span>
                                <input type="text" v-model="order.postal_office" placeholder="Введите отделение НП">
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
                    <label> Комментарий
                        <textarea v-model="order.comment" placeholder="Ваш комментарий..."></textarea>
                    </label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="ordering-right__inner">
                    <div class="ordering-cart">
                        <div class="ordering-item__title">
                            <h3>Заказ</h3>
                        </div>
                        <div class="ordering-cart__list">
                            <div class="ordering-cart__item" v-for="item in cart.list" :key="item.id">
                                <div class="img">
                                    <div class="img-inner">
                                        <img
                                            :src="item.image ? '/storage/products/350/' + item.image : '/images/no-image.png'"
                                            :alt="item.name">
                                    </div>
                                </div>
                                <div class="line"></div>
                                <div class="title">{{ item.name }}</div>
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
                                    <div v-else>
                                        <div class="size">Размер и цвет не выбран</div>
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
                                    <div class="label">Цена без скидки</div>
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
                                    <div class="label">К оплате</div>
                                    <div class="value">
                                        <div class="product-card__price">
                                            <div class="price total">{{ cart.totalPrice }} грн.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons">
                                <a href="javascript:" class="button-checkout" @click.prevent="sendOrder">Заказать</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Inputmask from 'inputmask';
import destroyIcon from '../../components/icons/DestroyIcon';

export default {
    components: {
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

            axios.post('https://graph.facebook.com/' + self.$fb_api_version + '/' + self.$fb_pixel_id + '/events?access_token=' + self.$fb_api, {
                "data": [
                    {
                        "event_name": "InitiateCheckout",
                        "event_time": Math.floor(Date.now() / 1000),
                        "action_source": "website",
                        "event_source_url": window.location.href,
                        "user_data": {
                            "ct": [hash.sha256().update(self.cityName).digest('hex')],
                            "country": [hash.sha256().update(self.countryName).digest('hex')],
                            "client_ip_address": self.ip,
                            "client_user_agent": self.userAgent,
                        },
                        "custom_data": {
                            "value": self.cart.totalPrice,
                            "currency": "UAH",
                            "num_items": self.cart.totalCount,
                            "content_ids": self.contentIds,
                            "content_type": "product"
                        }
                    }
                ]
            });
            fbq('track', 'AddToCart', {
                "value": self.cart.totalPrice,
                "currency": "UAH",
                "num_items": self.cart.totalCount,
                "content_ids": self.contentIds,
                "content_type": "product"
            });
            self.fbInitiateCheckout = false;
        }
    },
    mounted() {
        new Inputmask("+38 (999) 999-99-99").mask(document.getElementById('input-phone'));
    },
    methods: {
        removeFromCart(id) {
            axios.delete('/api/v1/cart/delete/' + id)
                .then(() => this.deleteCartListSuccessResponse())
                .catch((response) => this.deleteCartListErrorResponse(response));
        },
        deleteCartListSuccessResponse() {
            this.$store.commit('loadCart');
        },
        deleteCartListErrorResponse(response) {
            console.log(response);
        },
        sendOrder() {
            this.isLoading = true;
            axios.post('/api/v1/order/create', this.order)
                .then(() => this.sendFormSuccessResponse())
                .catch(({response}) => this.sendFormErrorResponse(response));
        },
        sendFormSuccessResponse() {
            axios.post('https://graph.facebook.com/' + this.$fb_api_version + '/' + this.$fb_pixel_id + '/events?access_token=' + this.$fb_api, {
                "data": [
                    {
                        "event_name": "Purchase",
                        "event_time": Math.floor(Date.now() / 1000),
                        "action_source": "website",
                        "event_source_url": window.location.href,
                        "user_data": {
                            "ph": [hash.sha256().update(this.order.phone).digest('hex')],
                            "ct": [hash.sha256().update(this.cityName).digest('hex')],
                            "country": [hash.sha256().update(this.countryName).digest('hex')],
                            "client_ip_address": this.ip,
                            "client_user_agent": this.userAgent,
                        },
                        "custom_data": {
                            "value": this.cart.totalPrice,
                            "currency": "UAH",
                            "content_type": "product",
                            "num_items": this.cart.totalCount,
                            "content_ids": this.contentIds
                        }
                    }
                ]
            });
            this.isLoading = false;
            this.$swal({
                title: 'Отправлено!',
                text: 'Ваша заявка отправлена :)',
                icon: 'success',
            });
            window.location.href = '/send-form';
        },
        sendFormErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность введенных данных, или же обратитесь по контактным данным',
                icon: 'error',
            });
        }
    }
}
</script>
