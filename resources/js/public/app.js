import Vue from "vue";
import Vuex from 'vuex';
import store from "./includes/store";
import Paginate from 'vuejs-paginate'


Vue.component('paginate', Paginate)
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

window.axios = require('axios');

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
Vue.component('faq-component', require('./components/FaqComponent').default);

/**
 * Vue Product components
 */
Vue.component('main-banners', require('./home/MainBanners').default);
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

window.hash = require('hash.js');


Vue.prototype.$fb_api = 'EAAErmzE35MMBADkZBJgPpKpm836MOGaojDZA8ZBCUuCStZCfj3I2rLY6Dkvwmvj91mRGKKtdsdigMsKIHXsLYt6Fh7yqgL7tVcmY2VJ9MIl5dAtJhQIVE1scJGCa6ykDXDEIO6H6YGnAIDtupLoWx3ESuneoTXkZC6tZAfttiLi8cGWzIMaxYKF8Q8Nd8dHtwZD';
Vue.prototype.$fb_pixel_id = '2420788534721287';
Vue.prototype.$fb_api_version = 'v11.0';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store),
    data() {
        return {
            ip: null,
            cityName: null,
            countryName: null,
            zipCode: null,
        }
    },
    mounted() {
        axios.get('/api/v1/user/info')
            .then(({data}) => {
                if (data.location.ip !== '66.102.0.0') {
                    this.ip = data.location.ip;
                    this.cityName = data.location.cityName;
                    this.countryName = data.location.countryName;
                    this.zipCode = data.location.zipCode;
                    this.userAgent = data.userAgent;
                }
            });

        axios.post('https://graph.facebook.com/' + this.$fb_api_version + '/' + this.$fb_pixel_id + '/events?access_token=' + this.$fb_api, {
            "data": [
                {
                    "event_name": "PageView",
                    "event_time": Math.floor(Date.now() / 1000),
                    "action_source": "website",
                    "event_source_url": window.location.href,
                    "user_data": {
                        "ct": [hash.sha256().update(this.cityName).digest('hex')],
                        "country": [hash.sha256().update(this.countryName).digest('hex')],
                        "client_ip_address": this.ip,
                        "client_user_agent": this.userAgent
                    }
                }
            ]
        });
    }
});
