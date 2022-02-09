<template>
    <div v-if="permissions.showOrders || permissions.adminPermission">
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col-12 col-md-2">
                    <button class="btn btn-danger w-100 m-1 m-md-0" @click.prevent="getOrders">Очистить</button>
                </div>
                <div class="col-12 col-md-2">
                    <select class="form-control w-100 m-1 m-md-0" id="status" v-model="searchParam">
                        <option :value="null">Общий поиск</option>
                        <option value="id">По ID</option>
                        <option value="waybill">По ТТН</option>
                        <option value="comment">По комментарию</option>
                        <option value="phone">По номеру</option>
                        <option value="name">По имени</option>
                        <option value="last_name">По фамилии</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <input type="text" v-model="search" class="form-control mx-1 w-100 m-1 m-md-0">
                </div>
                <div class="col-12 col-md-2">
                    <button @click.prevent="getSearchList" type="submit" class="btn btn-danger w-100 m-1 m-md-0">Поиск
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="getOrders"
                            >Все заказы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusNew)"
                            >Новые</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusAtThePostOffice)"
                            >{{ statusAtThePostOffice }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusAwaitingDispatch)"
                            >{{ statusAwaitingDispatch }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusAwaitingPrepayment)"
                            >{{ statusAwaitingPrepayment }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusCanceled)"
                            >{{ statusCanceled }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusDone)"
                            >{{ statusDone }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusOnTheRoad)"
                            >{{ statusOnTheRoad }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusProcessed)"
                            >{{ statusProcessed }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusReturn)"
                            >{{ statusReturn }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(statusTransferredToSupplier)"
                            >{{ statusTransferredToSupplier }}</a>
                        </li>
                    </ul>
                    <hr>
                    <ul v-if="permissions.adminPermission || role.administrator"
                        class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="/admin/orders/export"
                            >Экспортировать заказы</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-10">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-center">
                            <tr style="vertical-align: middle;">
                                <th>
                                    <input class="form-check-input"
                                           type="checkbox"
                                           v-model="checkedAll"
                                           @change="checkAll"
                                    >
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">ID</div>
                                        <a href="javascript:" class="text-dark" @click="sort('id','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('id','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Статус</div>
                                        <a href="javascript:" class="text-dark" @click="sort('status','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('status','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Номер телефона</th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Кол-во товаров</div>
                                        <a href="javascript:" class="text-dark" @click="sort('total_count','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('total_count','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Сумма</div>
                                        <a href="javascript:" class="text-dark" @click="sort('total_price','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('total_price','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th v-if="activeItem === statusTransferredToSupplier">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">ТТН</div>
                                        <a href="javascript:" class="text-dark" @click="sort('waybill','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('waybill','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th v-if="activeItem === statusCanceled || activeItem === statusTransferredToSupplier || activeItem === statusReturn || activeItem === statusDone">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Комментарий</div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Создано</div>
                                        <a href="javascript:" class="text-dark" @click="sort('created_at','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('created_at','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                    <hr class="m-1">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Обновлено</div>
                                        <a href="javascript:" class="text-dark" @click="sort('updated_at','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('updated_at','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <tr v-if="orders.length === 0">
                                <td colspan="10">
                                    <div class="row justify-content-center flex-column align-content-center">
                                        <div class="h2">Заказы отсутствуют</div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="order in orders" :key="order.id" style="vertical-align: middle;">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               :value="order.id"
                                               v-model="checkedItems"
                                        >
                                    </div>
                                </td>
                                <td>{{ order.id }}</td>
                                <td>{{ order.status }}</td>
                                <td>
                                    <a :href="'/admin/orders/edit/' + order.id">
                                        {{ order.client ? order.client.name : '-' }}
                                    </a>
                                </td>
                                <td>
                                    <a :href="'/admin/orders/edit/' + order.id">
                                        {{ order.client ? order.client.last_name : '-' }}
                                    </a>
                                </td>
                                <td>
                                    <a :href="'tel:' + order.phone">
                                        {{ order.client ? order.client.phone : '-' }}
                                    </a>
                                </td>
                                <td>{{ order.total_count }}</td>
                                <td>{{ order.total_price | formatMoney }} грн.</td>
                                <td v-if="activeItem === statusTransferredToSupplier">{{ order.waybill }}</td>
                                <td v-if="activeItem === statusCanceled || activeItem === statusTransferredToSupplier || activeItem === statusReturn || activeItem === statusDone"
                                    class="w-25"
                                >{{ order.comment ? order.comment.substr(0, 30) + '...' : '-' }}
                                </td>
                                <td>
                                    {{ dateFormat(order.created_at) }}
                                    <hr class="m-1">
                                    {{ dateFormat(order.updated_at) }}
                                </td>
                                <td>
                                    <a v-bind:href="'/admin/orders/edit/' + order.id">
                                        <edit-icon></edit-icon>
                                    </a>
                                    <a v-if="permissions.adminPermission || role.administrator || permissions.deleteOrders"
                                       href="javascript:" @click="onDelete(order.id)">
                                        <destroy-icon></destroy-icon>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot v-if="orders.length !== 0">
                            <tr>
                                <th colspan="10">
                                    <select class="form-select"
                                            @change="selectedAction"
                                            v-model="checkedItemsAction"
                                    >
                                        <option :value="null">Выберите действия</option>
                                        <option :value="destroyMassAction"
                                                v-if="permissions.adminPermission || role.administrator || permissions.deleteOrders"
                                        >Удалить
                                        </option>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="10">
                                    <pagination
                                        v-model="currentPage"
                                        :records="total"
                                        :per-page="perPage"
                                        @paginate="fetch"
                                        :options="this.$paginateOptions"
                                    />
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    beforeCreate() {
        this.isLoading = true;
    },
    props: {
        destroyMassAction: String,
        statusNew: String,
        statusAtThePostOffice: String,
        statusAwaitingDispatch: String,
        statusAwaitingPrepayment: String,
        statusCanceled: String,
        statusDone: String,
        statusOnTheRoad: String,
        statusProcessed: String,
        statusReturn: String,
        statusTransferredToSupplier: String,

        administratorRole: String,
        managerRole: String,
        adminPermission: String,
        showOrdersPermission: String,
        deleteOrdersPermission: String,
    },
    data() {
        return {
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            orders: [],
            isLoading: true,
            endpoint: '/api/orders?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
            activeItem: null,
            searchParam: null,
            permissions: {
                showOrders: false,
                adminPermission: false,
                deleteOrders: false,
            },
            role: {
                administrator: false,
                manager: false,
            },
        }
    },
    created() {
        this.permissions.showOrders = JSON.parse(this.showOrdersPermission);
        this.permissions.adminPermission = JSON.parse(this.adminPermission);
        this.permissions.deleteOrders = JSON.parse(this.deleteOrdersPermission);
        this.role.administrator = JSON.parse(this.administratorRole);
        this.role.manager = JSON.parse(this.managerRole);
    },
    mounted() {
        this.getOrders();
    },
    methods: {
        filter(value) {
            this.isLoading = true;
            this.activeItem = value;

            axios.get('/api/orders/filter', {
                params:
                    {
                        by: value,
                    }
            })
                .then(({data}) => {
                    this.getOrdersListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/orders/filter?by=' + value + '&page=';
                })
                .catch((response) => this.getOrdersListErrorResponse(response));
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/orders', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getOrdersListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/orders?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getOrdersListErrorResponse(response));
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/orders/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getOrdersListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getOrders();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getOrders() {
            this.search = null;
            this.isLoading = true;
            this.activeItem = null;

            axios.get('/api/orders')
                .then(({data}) => {
                    this.getOrdersListSuccessResponse(data);
                    this.endpoint = '/api/orders?page=';
                })
                .catch((response) => this.getOrdersListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getOrders();
            } else {
                axios.get('/api/orders/search', {
                    params: {
                        param: this.searchParam,
                        value: this.search,
                    }
                })
                    .then(({data}) => {
                        this.getOrdersListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/orders/search?page=';
                    })
                    .catch((response) => this.getOrdersListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getOrdersListSuccessResponse(data) {
            this.isLoading = false;
            this.orders = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getOrdersListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getOrdersListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Видалити?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/orders/destroy/' + id)
                        .then(() => {
                            this.fetch(1);
                            this.$swal({
                                title: 'Видалено',
                                icon: 'success',
                                showCancelButton: false,
                            });
                        })
                        .catch((response) => {
                            console.log(response);
                            this.$swal({
                                title: 'Помилка',
                                icon: 'error',
                                showCancelButton: false,
                            });
                        });
                }
            });
        },
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.orders.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
    },
}
</script>
