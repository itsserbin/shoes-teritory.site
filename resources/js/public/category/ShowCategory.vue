<template>
    <div>
        <loader v-if="isLoading"></loader>
        <section v-if="!isLoading" class="product-list card">
            <div class="product-list__title">{{ categoryTitle }}</div>
            <product-cards :products="products"
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
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: null,
            products: [],
            isLoading: false,
            isLoadingMore: false,
            showLoadMore: true,
            currentPage: 1,
            total: 1,
            endpoint: `/api/v1/product/category/?page=`
        }
    },
    mounted() {
        this.isLoading = true;
        this.endpoint = '/api/v1/product/category/' + this.categorySlug + '?page=';

        axios.get('/api/v1/product/category/' + this.categorySlug)
            .then(({data}) => this.getCategoryProductSuccessResponse(data))
            .catch((response) => this.getCategoryProductErrorResponse(response));
    },
    props: {
        categoryId: String,
        categoryTitle: String,
        categorySlug: String,
        lang: String,
        textLoadMore: String,
        textGoToProductCard: String,
        productRoute: String,
    },
    methods: {
        getCategoryProductSuccessResponse(data) {
            this.isLoading = false;
            this.products = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.showLoadMore = (data.result.to !== data.result.total);
        },
        getCategoryProductErrorResponse(response) {
            this.isLoading = false;
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
