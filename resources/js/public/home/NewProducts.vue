<template>
    <div>
        <loader v-if="isLoading"></loader>
        <product-cards v-if="!isLoading"
                       :products="products"
                       :lang="lang"
                       :text-go-to-product-card="textGoToProductCard"
                       :product-route="productRoute"
        ></product-cards>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: true,
            isLoadingMore: false,
            showLoadMore: true,
            products: [],
            currentPage: 1,
            total: 1,
            endpoint: '/api/v1/product/new-products?page='
        }
    },
    props: {
        lang: String,
        textLoadMore: String,
        textGoToProductCard: String,
        productRoute: String,
    },
    mounted() {
        axios.get('/api/v1/product/new-products')
            .then(({data}) => {
                this.isLoading = false;
                this.products = data.result;
            })
            .catch((response) => console.log(response));
    }
}
</script>
