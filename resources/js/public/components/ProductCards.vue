<template>
    <div class="row justify-content-center">
        <div class="product-list">
            <product-card  v-for="(product,i) in products"
                           :product="product"
                           :key="i"
                           :lang="lang"
                           :text-go-to-product-card="textGoToProductCard"
                           :product-route="productRoute"
            ></product-card>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        products: Array,
        lang: String,
        textGoToProductCard: String,
        productRoute: String,
    }
}
</script>
