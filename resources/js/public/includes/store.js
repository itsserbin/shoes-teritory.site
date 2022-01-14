let store = {
    debug: true,
    state: {
        list: [],
        totalCount: 0,
        totalPrice: 0.00,
        promo_code: null,
        price_without_discount: 0,
    },
    mutations: {
        loadCart(state) {
            axios.get('/api/v1/cart/list')
                .then(function ({data}) {
                    state.list = data.result.list;
                    state.totalCount = data.result.totalCount;
                    state.totalPrice = data.result.totalPrice;
                    state.promo_code = data.result.promo_code;
                    state.price_without_discount = data.result.price_without_discount;
                })
                .catch(function (response) {
                    if (this.debug) {
                        console.log(response);
                    }
                })
        },
    },
};

export default store;
