require('../bootstrap')

import Vue from "vue";
import VueSweetalert2 from 'vue-sweetalert2';
import Pagination from 'vue-pagination-2';
import VueDatePicker from '@mathieustan/vue-datepicker';

Vue.use(VueSweetalert2);
Vue.use(VueDatePicker);
Vue.use(require('vue-moment'));

Vue.component('pagination', Pagination);

let numeral = require("numeral");

Vue.filter("formatMoney", function (value) {
    return numeral(value).format('0,0[.]00');
});
Vue.filter("formatPercent", function (value) {
    return numeral(value).format('0.000%');
});


// Get components
Vue.component('loader', require('../components/LoaderComponent').default);
Vue.component('input-invalid-feedback', require('../components/InputInvalidFeedback').default);

// Get icons
Vue.component('arrow-up-icon', require('../components/icons/ArrowUpIcon').default);
Vue.component('arrow-down-icon', require('../components/icons/ArrowDown').default);
Vue.component('edit-icon', require('../components/icons/EditIcon').default);
Vue.component('destroy-icon', require('../components/icons/DestroyIcon').default);
Vue.component('save-icon', require('../components/icons/SaveIcon').default);
Vue.component('backspace-icon', require('../components/icons/BackspaceIcon').default);
Vue.component('arrows-angle-expand-icon', require('../components/icons/ArrowsAngleExpand').default);
Vue.component('telephone-icon', require('../components/icons/TelephoneIcon').default);

Vue.component('admin-dashboard', require('./AdminDashboard').default);

Vue.component('reviews-list', require('./reviews/ReviewsList').default);
Vue.component('edit-review', require('./reviews/EditReview').default);

Vue.component('products-list', require('./products/ProductsList').default);
Vue.component('edit-product', require('./products/EditProduct').default);
Vue.component('create-product', require('./products/CreateProduct').default);

Vue.component('clients-list', require('./clients/ClientsList').default);
Vue.component('edit-client', require('./clients/EditClient').default);

Vue.component('categories-list', require('./categories/CategoriesList').default);
Vue.component('category-create', require('./categories/CategoryCreate').default);
Vue.component('category-edit', require('./categories/EditCategory').default);

Vue.component('main-options-list', require('./options/MainOptionsList').default);
Vue.component('scripts-options-list', require('./options/ScriptsOptionsList').default);

Vue.component('users-list', require('./users/UsersList').default);
Vue.component('edit-user', require('./users/EditUser').default);
Vue.component('create-user', require('./users/CreateUser').default);

Vue.component('orders-list', require('./orders/OrdersList').default);
Vue.component('order-edit', require('./orders/EditOrder').default);

Vue.component('promo-codes-list', require('./promo-codes/PromoCodesList').default);
Vue.component('create-promo-code', require('./promo-codes/CreatePromoCode').default);
Vue.component('edit-promo-code', require('./promo-codes/EditPromoCode').default);

Vue.component('bookkeeping-daily-statistics', require('./bookkeeping/DailyStatistics').default);
Vue.component('supplier-payments', require('./bookkeeping/SupplierPaymentsList').default);

Vue.component('bookkeeping-managers-salaries', require('./bookkeeping/managers-salaries/ManagersSalaries').default);
Vue.component('bookkeeping-add-day-to-managers-salaries', require('./bookkeeping/managers-salaries/AddDayToManagersSalaries').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.prototype.$tinyapi = 'ufqphs7puyg4ij1mc3c61o7isu5mxekk5x9yygffpdo89ava';
Vue.prototype.$tinySettings = {plugins: 'table', height: 300};
Vue.prototype.$paginateOptions = {
    theme: 'bootstrap4',
    texts: {
        count: 'Показано {from}-{to} / {count} записей|{count} записей|Одна запись'
    },
};

const app = new Vue({
    el: '#app',
});
