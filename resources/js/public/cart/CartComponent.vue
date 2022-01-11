<template>
    <a href="/checkout" class="text-decoration-none text-dark">
        (<span>{{ cart.totalCount }}</span>)
        <cart-icon></cart-icon>
    </a>
</template>

<script>
export default {
    data() {
        return {
            cart: this.$store.state,
        }
    },
    mounted() {
        this.$store.commit('loadCart');
    },
    methods: {
        removeFromCart(id) {
            axios.delete('/api/v1/cart/delete/' + id)
                .then(() => this.deleteCartListSuccessResponse())
                .catch((response) => this.deleteCartListErrorResponse(response));
        },

        deleteCartListSuccessResponse() {
            this.$store.commit('loadCart');
        },

        deleteCartListErrorResponse(response) {
            console.log(response);
        },
    }
}
</script>
