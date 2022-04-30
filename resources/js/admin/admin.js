require('../bootstrap')

import Vue from "vue";
import VueSweetalert2 from 'vue-sweetalert2';
import Pagination from 'vue-pagination-2';
import VueDatePicker from '@mathieustan/vue-datepicker';
import Multiselect from 'vue-multiselect'
import {ModelListSelect} from 'vue-search-select'
import VueApexCharts from 'vue-apexcharts'

Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)


Vue.component('multiselect', Multiselect)
Vue.component('model-list-select', ModelListSelect)

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
Vue.component('admin-header', require('./components/Header').default);

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

Vue.component('pages-list', require('./pages/PagesList').default);
Vue.component('create-page', require('./pages/CreatePage').default);
Vue.component('edit-page', require('./pages/EditPage').default);

Vue.component('faq-list', require('./faq/FaqList').default);
Vue.component('create-faq', require('./faq/CreateFaq').default);
Vue.component('edit-faq', require('./faq/EditFaq').default);

Vue.component('banners-list', require('./banners/BannersList').default);
Vue.component('create-banner', require('./banners/CreateBanner').default);
Vue.component('edit-banner', require('./banners/EditBanner').default);

Vue.component('users-list', require('./users/UsersList').default);
Vue.component('edit-user', require('./users/EditUser').default);
Vue.component('create-user', require('./users/CreateUser').default);

Vue.component('translations-list', require('./translations/TranslationsList').default);
Vue.component('create-translation', require('./translations/CreateTranslation').default);

Vue.component('advantages-list', require('./advantages/AdvantagesList').default);
Vue.component('create-advantage', require('./advantages/CreateAdvantage').default);
Vue.component('edit-advantage', require('./advantages/EditAdvantage').default);

Vue.component('orders-list', require('./orders/OrdersList').default);
Vue.component('order-edit', require('./orders/EditOrder').default);

Vue.component('providers-list', require('./providers/ProvidersList').default);
Vue.component('create-provider', require('./providers/CreateProvider').default);
Vue.component('edit-provider', require('./providers/EditProvider').default);

Vue.component('colors-list', require('./options/colors/ColorsList').default);
Vue.component('create-color', require('./options/colors/CreateColor').default);
Vue.component('edit-color', require('./options/colors/EditColor').default);

Vue.component('promo-codes-list', require('./promo-codes/PromoCodesList').default);
Vue.component('create-promo-code', require('./promo-codes/CreatePromoCode').default);
Vue.component('edit-promo-code', require('./promo-codes/EditPromoCode').default);

Vue.component('bookkeeping-profits-list', require('./bookkeeping/profit/ProfitList').default);
Vue.component('bookkeeping-profits-create', require('./bookkeeping/profit/AddDay').default);

Vue.component('bookkeeping-marketing-statistic', require('./bookkeeping/marketing-statistic/MarketingStatisticList').default);

Vue.component('bookkeeping-orders-statistics', require('./bookkeeping/orders-statistic/OrdersStaticticList').default);

Vue.component('bookkeeping-statistics-card', require('./bookkeeping/components/StatisticsCard').default);

Vue.component('bookkeeping-costs-list', require('./bookkeeping/costs/CostsList').default);
Vue.component('bookkeeping-costs-create', require('./bookkeeping/costs/CreateCost').default);
Vue.component('bookkeeping-costs-edit', require('./bookkeeping/costs/EditCost').default);

Vue.component('bookkeeping-costs-categories-list', require('./bookkeeping/costs/categories/CostCategoriesList').default);
Vue.component('bookkeeping-costs-categories-create', require('./bookkeeping/costs/categories/CreateCostCategory').default);
Vue.component('bookkeeping-costs-categories-edit', require('./bookkeeping/costs/categories/EditCostCategory').default);

Vue.component('supplier-payments', require('./bookkeeping/SupplierPaymentsList').default);

Vue.component('bookkeeping-managers-salaries', require('./bookkeeping/managers-salaries/ManagersSalaries').default);
Vue.component('bookkeeping-add-day-to-managers-salaries', require('./bookkeeping/managers-salaries/AddDayToManagersSalaries').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.prototype.$tinyapi = 'ufqphs7puyg4ij1mc3c61o7isu5mxekk5x9yygffpdo89ava';
Vue.prototype.$tinySettings = {
    plugins: ['table', 'code', 'lists'],
    height: 300,
    branding: false,
    toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
};
Vue.prototype.$paginateOptions = {
    theme: 'bootstrap4',
    texts: {
        count: 'Показано {from}-{to} / {count} записей|{count} записей|Одна запись'
    },
};

const app = new Vue({
    el: '#app',
});
