<template>
    <div class="row justify-content-center">
        <div class="card__product my-3"
             v-for="product in products"
        >
            <a class="text-decoration-none"
               v-bind:href="'/product/' + product.id"
            >

                <div class="card__image">
                    <img :src="'/storage/products/350/' + product.preview" :alt="product.h1">
                </div>

                <div class="card__body">
                    <h5 class="card__label">{{ product.h1 }}</h5>
                    <div class="card__price">
                        <div v-if="product.discount_price === null"
                             class="card__price-without-discount">{{ product.price }} грн.
                        </div>

                        <div v-if="product.discount_price > null">
                            <div class="card__old-price">{{ product.price }} грн.</div>
                            <div class="card__actual-price">{{ product.discount_price }} грн.</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        products: Array,
    }
}
</script>
