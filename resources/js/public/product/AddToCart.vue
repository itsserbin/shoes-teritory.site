<template>
    <div>
        <div class="row mb-4">
            <div class="shop__price d-flex align-items-center">
                <div class="col-6">
                    <div v-if="discountPrice" class="d-flex align-items-center justify-content-evenly">
                        <div class="shop__old-price">{{ price }} грн.</div>
                        <div class="shop__actual-price">{{ discountPrice }} грн.</div>
                    </div>
                    <div v-if="!discountPrice">
                        <div class="shop__price-without-discount">{{ price }} грн.</div>
                    </div>
                </div>
                <div class="col-6">
                    <button
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

                    <div v-if="xs" class="size__element me-1 mb-2">
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

                    <div v-if="s" class="size__element me-1 mb-2">
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

                    <div v-if="m" class="size__element me-1 mb-2">
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

                    <div v-if="l" class="size__element me-1 mb-2">
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

                    <div v-if="xl" class="size__element me-1 mb-2">
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

                    <div v-if="xxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="xxl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">XXL</span>
                            <span class="mycheckbox__descr"></span>
                        </label>

                    </div>

                    <div v-if="xxxl" class="size__element me-1 mb-2">
                        <label class="mycheckbox">
                            <input value="xxxl"
                                   class="mycheckbox__default"
                                   type="checkbox"
                                   v-model="item.size"
                            >
                            <span class="mycheckbox__new">XXXL</span>
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
        xs: String,
        s: String,
        m: String,
        l: String,
        xl: String,
        xxl: String,
        xxxl: String,
    },
    created() {
        this.colorsAll = JSON.parse(this.colors);
        this.item.item_id = this.id;
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
        buyNow() {
            axios.post('/api/v1/cart/add', this.item)
                .then(({data}) => window.location.href = '/checkout')
                .catch(({response}) => this.setErrorResponse(response));
        },
        addToCart() {
            axios.post('/api/v1/cart/add', this.item)
                .then(({data}) => {
                    this.$store.commit('loadCart');
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
                            window.location.href = '/checkout';
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
