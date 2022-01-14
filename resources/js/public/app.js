import Vue from "vue";
import Vuex from 'vuex';
import store from "./includes/store";
import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

window.axios = require('axios');
// window.swal = Swal;

Vue.use(Vuex)

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('loader', require('../components/LoaderComponent').default);

Vue.component('cart-icon', require('../components/icons/CartIcon').default);
Vue.component('facebook-icon', require('../components/icons/FacebookIcon').default);
Vue.component('instagram-icon', require('../components/icons/InstagramIcon').default);
Vue.component('telegram-icon', require('../components/icons/TelegramIcon').default);
Vue.component('viber-icon', require('../components/icons/ViberIcon').default);

Vue.component('header-component', require('./components/Header').default);
Vue.component('all-reviews-component', require('./components/AllReviews').default);
Vue.component('delivery-and-return-accordion', require('./components/DeliveryAndReturnAccordion').default);

/**
 * Vue Cart components
 */
Vue.component('cart-icon-component', require('./cart/CartIconComponent').default);
Vue.component('add-to-cart', require('./product/AddToCart').default);
Vue.component('checkout', require('./cart/CheckoutComponent').default);
Vue.component('cart-component', require('./cart/Cart').default);

/**
 * Vue Product components
 */
Vue.component('best-selling-products', require('./home/BestSelling').default);
Vue.component('all-products', require('./home/AllProducts').default);
Vue.component('product-cards', require('./components/ProductCards').default);
Vue.component('sizes-table', require('./product/SizesTable').default);
Vue.component('review-form', require('./product/ReviewForm').default);
Vue.component('images-slider', require('./product/ImagesSlider').default);
Vue.component('product-reviews', require('./product/ProductReviews').default);
Vue.component('relative-products', require('./product/RelativeProducts').default);

/**
 * Vue categories components
 */
Vue.component('categories-grid', require('./category/CategoriesGrid').default);
Vue.component('category', require('./category/ShowCategory').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
});
