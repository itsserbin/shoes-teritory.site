<template>
    <div class="row justify-content-center">
        <product-card  v-for="(product,i) in products" :product="product" :key="i"></product-card>
    </div>
</template>

<script>
export default {
    props: {
        products: Array,
    }
}
</script>
