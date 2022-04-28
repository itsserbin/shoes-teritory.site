<template>
    <section class="relative product-list">
        <div class="container">
            <div class="row my-5">
                <div class="relative__title block-title">{{ textLatestProducts }}</div>
                <div class="relative-slider">
                    <VueSlickCarousel v-bind="settings" v-if="products.length">
                        <div v-for="(product,i) in products" :key="i" class="card__product p-2">
                            <a :href="productRoute + '/' + product.id" class="text-decoration-none">
                                <div class="card__image">
                                    <img :src="'/storage/products/500/' + product.preview"
                                         :alt="lang === 'ru' ? product.h1.ru :product.h1.ua">
                                </div>
                                <div class="card__body">
                                    <h5 class="card__label">{{ lang === 'ru' ? product.h1.ru :product.h1.ua }}</h5>
                                    <div class="card__price">
                                        <div v-if="product.discount_price !== 0">
                                            <div class="card__old-price">{{ product.price }} грн.</div>
                                            <div class="card__actual-price">{{ product.discount_price }} грн.</div>
                                        </div>
                                        <div v-else>
                                            <div class="card__price-without-discount">{{ product.price }} грн.</div>
                                        </div>
                                    </div>
                                    <span class="card__button">{{ textGoToProductCard }}</span>
                                </div>
                            </a>
                        </div>
                    </VueSlickCarousel>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'

import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: {VueSlickCarousel},
    data() {
        return {
            products: [],
            settings: {
                "lazyLoad": "ondemand",
                "dots": true,
                "arrows": false,
                "dotsClass": "slick-dots",
                "edgeFriction": 0.35,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 5,
                "slidesToScroll": 3,
                "responsive": [
                    {
                        "breakpoint": 1024,
                        "settings": {
                            "slidesToShow": 4,
                            "slidesToScroll": 3,
                            "infinite": true,
                            "dots": true
                        }
                    },
                    {
                        "breakpoint": 768,
                        "settings": {
                            "slidesToShow": 3,
                            "slidesToScroll": 2,
                        }
                    },
                    {
                        "breakpoint": 480,
                        "settings": {
                            "slidesToShow": 2,
                            "slidesToScroll": 2
                        }
                    }
                ]
            }
        }
    },
    mounted() {
        axios.get('/api/v1/product/new-products')
            .then(({data}) => this.products = data.result)
            .catch((response) => console.log(response));
    },
    props: {
        textLatestProducts: String,
        lang: String,
        textGoToProductCard: String,
        productRoute: String
    }
}
</script>
