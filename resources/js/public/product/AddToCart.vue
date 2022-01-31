<template>
    <div>
        <div class="row mb-4">
            <div class="shop__price d-flex align-items-center">
                <div class="col-6">
                    <div v-if="discountPrice" class="d-flex align-items-center justify-content-evenly flex-column">
                        <div class="shop__old-price">{{ price }} грн.</div>
                        <div class="shop__actual-price">{{ discountPrice }} грн.</div>
                    </div>
                    <div v-if="!discountPrice">
                        <div class="shop__price-without-discount">{{ price }} грн.</div>
                    </div>
                </div>
                <div class="col-6">
                    <button
                        v-if="availability !== 'out of stock'"
                        disabled
                        class="shop__button order-button button button--color_red button--color-text_white"
                        type="button"
                        @click="addToCart"
                    >
                        <span class="icon-cart"></span>
                        <span>Купить</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-md-6 mb-3">
                <div class="shop__available-sizes available-sizes">
                    <div class="shop__available-sizes__label w-100 mb-2">Доступные размеры:</div>

                    <div v-if="size.xs" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input v-model="item.size"
                                   value="xs"
                                   class="mycheckbox__default"
                                   type="checkbox"
                            >
                            <span class="mycheckbox__new">XS</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.s" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input v-model="item.size"
                                   value="s"
                                   class="mycheckbox__default"
                                   type="checkbox"
                            >
                            <span class="mycheckbox__new">S</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.m" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input v-model="item.size"
                                   value="m"
                                   class="mycheckbox__default"
                                   type="checkbox"
                            >
                            <span class="mycheckbox__new">M</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.l" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input v-model="item.size"
                                   value="l"
                                   class="mycheckbox__default"
                                   type="checkbox"
                            >
                            <span class="mycheckbox__new">L</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.xl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="xl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">XL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.xxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="2xl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">2XL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>

                    </div>

                    <div v-if="size.xxxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="3xl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">3XL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>
                    <div v-if="size.xxxxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="4xl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">4XL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>

                    <div v-if="size.xxxxxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="5xl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">5XL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3" v-if="colorsAll.length">
                <div class="available-colors">
                    <div class="available-colors__label w-100 mb-2">Доступные цвета:</div>
                    <div v-for="colors_item in colorsAll" :key="colors_item.id">
                        <label class="mycheckbox" :style="'background-color:' + colors_item.hex ">
                            <input :value="colors_item.name"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.color"
                            >
                            <span class="mycheckbox__new"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <sizes-table :size-table="sizeTable"></sizes-table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            item: {
                count: 1,
                size: [],
                color: [],
                item_id: null,
            },
            size: {
                xs: 0,
                s: 0,
                m: 0,
                l: 0,
                xl: 0,
                xxl: 0,
                xxxl: 0,
                xxxxl: 0,
                xxxxxl: 0,
            },
            colorsAll: [],
            productColors: [],
            showModal: false,
            cart: this.$store.state,
        };
    },
    props: {
        id: String,
        colors: String,
        price: String,
        sizeTable: String,
        discountPrice: String,
        h1: String,
        category: String,
        xs: String,
        s: String,
        m: String,
        l: String,
        xl: String,
        xxl: String,
        xxxl: String,
        xxxxl: String,
        xxxxxl: String,
        availability: String,
    },
    created() {
        this.colorsAll = JSON.parse(this.colors);
        this.item.item_id = this.id;
        this.size.xs = JSON.parse(this.xs);
        this.size.s = JSON.parse(this.s);
        this.size.m = JSON.parse(this.m);
        this.size.l = JSON.parse(this.l);
        this.size.xl = JSON.parse(this.xl);
        this.size.xxl = JSON.parse(this.xxl);
        this.size.xxxl = JSON.parse(this.xxxl);
        this.size.xxxxl = JSON.parse(this.xxxxl);
        this.size.xxxxxl = JSON.parse(this.xxxxxl);
    },
    mounted() {
        axios.post('https://graph.facebook.com/' + this.$fb_api_version + '/' + this.$fb_pixel_id + '/events?access_token=' + this.$fb_api, {
            "data": [
                {
                    "event_name": "ViewContent",
                    "event_time": Math.floor(Date.now() / 1000),
                    "action_source": "website",
                    "event_source_url": window.location.href,
                    "user_data": {
                        "ct": [hash.sha256().update(this.cityName).digest('hex')],
                        "country": [hash.sha256().update(this.countryName).digest('hex')],
                        "client_ip_address": this.ip,
                        "client_user_agent": this.userAgent,
                    },
                    "custom_data": {
                        "value": this.discountPrice ? this.discountPrice : this.price,
                        "currency": "UAH",
                        "content_type": "product",
                        "content_ids": [this.item.item_id],
                        "content_category": this.category,
                        "content_name": this.h1
                    }
                }
            ]
        });
        fbq('track', 'ViewContent', {
            "value": this.discountPrice ? this.discountPrice : this.price,
            "currency": "UAH",
            "content_type": "product",
            "content_ids": [this.item.item_id],
            "content_category": this.category,
            "content_name": this.h1
        });
    },
    methods: {
        showModalFunction() {
            this.showModal = !this.showModal;
        },
        onIncrement() {
            this.item.count++;
        },
        onDecrement() {
            if (this.item.count > 1) {
                this.item.count--;
            }
        },
        addToCart() {
            axios.post('/api/v1/cart/add', this.item)
                .then(({data}) => {
                    this.$store.commit('loadCart');
                    axios.post('https://graph.facebook.com/' + this.$fb_api_version + '/' + this.$fb_pixel_id + '/events?access_token=' + this.$fb_api, {
                        "data": [
                            {
                                "event_name": "AddToCart",
                                "event_time": Math.floor(Date.now() / 1000),
                                "action_source": "website",
                                "event_source_url": window.location.href,
                                "user_data": {
                                    "ct": [hash.sha256().update(this.cityName).digest('hex')],
                                    "country": [hash.sha256().update(this.countryName).digest('hex')],
                                    "client_ip_address": this.ip,
                                    "client_user_agent": this.userAgent,
                                },
                                "custom_data": {
                                    "value": this.discountPrice ? this.discountPrice : this.price,
                                    "currency": "UAH",
                                    "content_type": "product",
                                    "content_ids": [this.item.item_id],
                                    "content_name": this.h1
                                }
                            }
                        ]
                    });
                    fbq('track', 'AddToCart', {
                        "value": this.discountPrice ? this.discountPrice : this.price,
                        "currency": "UAH",
                        "content_type": "product",
                        "content_ids": [this.item.item_id],
                        "content_name": this.h1
                    });
                    this.$swal({
                        title: 'Добавлено!',
                        text: 'Товар в корзине :)',
                        icon: 'success',
                        showCancelButton: false,
                        showDenyButton: true,
                        confirmButtonText: 'Оформить заказ',
                        denyButtonText: `Продолжить покупки`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/cart';
                        }
                    });
                })
                .catch(() => {
                    this.$swal({
                        title: 'Ошибка!',
                        text: 'Что то сломалось :(',
                        icon: 'error',
                    });
                });
        }
    }
}
</script>
