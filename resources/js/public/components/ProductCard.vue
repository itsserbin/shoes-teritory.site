<template>
    <div class="card__product">
        <a class="text-decoration-none" :href="productRoute + '/' + product.id">

            <div class="card__image">
                <img :src="'/storage/products/350/' + product.preview" :alt="product.h1.ru" v-if="lang === 'ru'">
                <img :src="'/storage/products/350/' + product.preview" :alt="product.h1.ua" v-if="lang === 'ua'">
            </div>

            <div class="card__body">
                <h5 class="card__label" v-if="lang === 'ru'">{{ product.h1.ru }}</h5>
                <h5 class="card__label" v-if="lang === 'ua'">{{ product.h1.ua }}</h5>
                <div class="card__price">
                    <div v-if="!product.discount_price"
                         class="card__price-without-discount">{{ product.price }} грн.
                    </div>

                    <div v-if="product.discount_price" class="card__discount_price">
                        <div class="card__old-price">{{ product.price }} грн.</div>
                        <div class="card__actual-price">{{ product.discount_price }} грн.</div>
                    </div>
                </div>
                <span class="card__button">{{ textGoToProductCard }}</span>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
        lang: String,
        textGoToProductCard: String,
        productRoute: String
    }
}
</script>
