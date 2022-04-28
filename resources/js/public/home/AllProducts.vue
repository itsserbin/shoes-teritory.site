<template>
    <div>
        <loader v-if="isLoading"></loader>
        <product-cards v-if="!isLoading"
                       :products="products"
                       :lang="lang"
                       :text-go-to-product-card="textGoToProductCard"
                       :product-route="productRoute"
        ></product-cards>
        <div class="row d-flex justify-content-center" v-if="showLoadMore">
            <loader v-if="isLoadingMore"></loader>
            <button class="load-more__button" type="button" v-if="!isLoadingMore" @click="fetch">
                <span>{{ textLoadMore }}</span>
            </button>
        </div>
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
            endpoint: '/api/v1/product?page='
        }
    },
    props: {
        lang: String,
        textLoadMore: String,
        textGoToProductCard: String,
        productRoute: String,
    },
    mounted() {
        axios.get('/api/v1/product')
            .then(({data}) => this.deleteCartListSuccessResponse(data))
            .catch((response) => this.deleteCartListErrorResponse(response));
    },
    methods: {
        deleteCartListSuccessResponse(data) {
            this.isLoading = false;
            this.products = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.showLoadMore = (data.result.to !== data.result.total);
        },
        deleteCartListErrorResponse(response) {
            console.log(response);
        },
        fetch() {
            this.isLoadingMore = true;
            axios.get(this.endpoint + (this.currentPage + 1))
                .then(({data}) => {
                    this.isLoadingMore = false;
                    this.currentPage = data.result.current_page;
                    this.products = this.products.concat(data.result.data);
                    this.showLoadMore = (data.result.to !== data.result.total);
                });
        },
    }
}
</script>
