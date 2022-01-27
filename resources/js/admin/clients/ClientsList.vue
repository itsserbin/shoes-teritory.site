<template>
    <div v-if="permissions.showClients || permissions.adminPermission">
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getClients">Очистить</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Поиск</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="getClients"
                            >Все клиенты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(newStatus)"
                            >Новые</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(experiencedStatus)"
                            >{{ experiencedStatus }}</a>
                            <ul class="nav flex-column ms-3" v-if="activeItem === experiencedStatus">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="filter(experiencedStatus)"
                                    >Все</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(experiencedStatusSatisfied)"
                                    >{{ experiencedStatusSatisfied }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(experiencedStatusAskedForAnExchange)"
                                    >{{ experiencedStatusAskedForAnExchange }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(experiencedStatusNoResponse)"
                                    >{{ experiencedStatusNoResponse }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(experiencedStatusNotSatisfied)"
                                    >{{ experiencedStatusNotSatisfied }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(experiencedStatusInProgress)"
                                    >{{ experiencedStatusInProgress }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(returnStatus)"
                            >{{ returnStatus }}</a>
                            <ul class="nav flex-column ms-3" v-if="activeItem === returnStatus">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="filter(returnStatus)"
                                    >Все</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(returnStatusNew)"
                                    >{{ returnStatusNew }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(returnStatusAgreed)"
                                    >{{ returnStatusAgreed }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(returnStatusRefused)"
                                    >{{ returnStatusRefused }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active"
                                       href="javascript:"
                                       @click="subFilter(returnStatusDidntGetIntouch)"
                                    >{{ returnStatusDidntGetIntouch }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(topStatus)"
                            >{{ topStatus }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="javascript:"
                               @click="filter(blackListStatus)"
                            >{{ blackListStatus }}</a>
                        </li>
                    </ul>
                    <hr>
                    <ul v-if="permissions.adminPermission || role.administrator"
                        class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active"
                               href="/admin/clients/export"
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
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Доп. статус</div>
                                        <a href="javascript:" class="text-dark" @click="sort('sub_status','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('sub_status','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Имя</div>
                                        <a href="javascript:" class="text-dark" @click="sort('name','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('name','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Фамилия</div>
                                        <a href="javascript:" class="text-dark" @click="sort('last_name','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('last_name','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Телефон</div>
                                        <a href="javascript:" class="text-dark" @click="sort('phone','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('phone','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Кол-во покуполк</div>
                                        <a href="javascript:" class="text-dark"
                                           @click="sort('number_of_purchases','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark"
                                           @click="sort('number_of_purchases','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Средний чек</div>
                                        <a href="javascript:" class="text-dark" @click="sort('average_check','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('average_check','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Общий чек</div>
                                        <a href="javascript:" class="text-dark" @click="sort('whole_check','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('whole_check','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Комментарий</div>
                                        <a href="javascript:" class="text-dark" @click="sort('comment','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('comment','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Создан</div>
                                        <a href="javascript:" class="text-dark" @click="sort('created_at','asc')">
                                            <arrow-up-icon></arrow-up-icon>
                                        </a>
                                        <a href="javascript:" class="text-dark" @click="sort('created_at','desc')">
                                            <arrow-down-icon></arrow-down-icon>
                                        </a>
                                    </div>
                                    <hr class="m-1">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mr-1">Обновлен</div>
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
                            <tr v-if="clients.length === 0">
                                <td colspan="10">
                                    <div class="row justify-content-center flex-column align-content-center">
                                        <div class="h2">Клиенты отсутствуют</div>
                                    </div>
                                </td>
                            </tr>
                            <tr v-for="client in clients" :key="client.id" style="vertical-align: middle;">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               :value="client.id"
                                               v-model="checkedItems"
                                        >
                                    </div>
                                </td>
                                <td>{{ client.id }}</td>
                                <td>{{ client.status }}</td>
                                <td>{{ client.sub_status }}</td>
                                <td><a :href="'/admin/clients/edit/' + client.id">{{ client.name }}</a></td>
                                <td><a :href="'/admin/clients/edit/' + client.id">{{ client.last_name }}</a></td>
                                <td><a :href="'tel:' + client.phone">{{ client.phone }}</a></td>
                                <td>{{ client.number_of_purchases }}</td>
                                <td>{{ client.average_check | formatMoney }} грн.</td>
                                <td>{{ client.whole_check  | formatMoney }} грн.</td>
                                <td>{{ client.comment ? client.comment.substr(0, 30) + '...' : '-'}}</td>
                                <td>
                                    {{ dateFormat(client.created_at) }}
                                    <hr class="m-1">
                                    {{ dateFormat(client.updated_at) }}
                                </td>
                                <td>
                                    <a v-bind:href="'/admin/clients/edit/' + client.id">
                                        <edit-icon></edit-icon>
                                    </a>
                                    <a v-if="permissions.adminPermission || role.administrator || permissions.deleteClients"
                                        href="javascript:" @click="onDelete(client.id)">
                                        <destroy-icon></destroy-icon>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot v-if="clients.length !== 0">
                            <tr>
                                <th colspan="10">
                                    <select class="form-select"
                                            @change="selectedAction"
                                            v-model="checkedItemsAction"
                                    >
                                        <option :value="null">Виберите действие</option>
                                        <option :value="destroyMassAction"
                                                v-if="permissions.adminPermission || role.administrator || permissions.deleteClients"
                                        >Удалить</option>
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
        newStatus: String,
        experiencedStatus: String,
        returnStatus: String,
        topStatus: String,
        blackListStatus: String,

        returnStatusAgreed: String,
        returnStatusRefused: String,
        returnStatusDidntGetIntouch: String,
        returnStatusNew: String,

        experiencedStatusSatisfied: String,
        experiencedStatusAskedForAnExchange: String,
        experiencedStatusNoResponse: String,
        experiencedStatusNotSatisfied: String,
        experiencedStatusInProgress: String,

        administratorRole: String,
        managerRole: String,
        adminPermission: String,
        showClientsPermission: String,
        deleteClientsPermission: String,
    },
    data() {
        return {
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            activeItem: null,
            clients: [],
            isLoading: true,
            endpoint: '/api/clients?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
            permissions: {
                showClients: false,
                adminPermission: false,
                deleteClients: false,
            },
            role: {
                administrator: false,
                manager: false,
            },
        }
    },
    created() {
        this.permissions.showClients = JSON.parse(this.showClientsPermission);
        this.permissions.adminPermission = JSON.parse(this.adminPermission);
        this.permissions.deleteClients = JSON.parse(this.deleteClientsPermission);
        this.role.administrator = JSON.parse(this.administratorRole);
        this.role.manager = JSON.parse(this.managerRole);
    },
    mounted() {
        this.getClients();
    },
    methods: {
        filter(value) {
            this.isLoading = true;
            this.activeItem = value;

            axios.get('/api/clients/filter', {
                params:
                    {
                        by: value,
                    }
            })
                .then(({data}) => {
                    this.getClientsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/clients/filter?by=' + value + '&page=';
                })
                .catch((response) => this.getClientsListErrorResponse(response));
        },
        subFilter(value) {
            this.isLoading = true;

            axios.get('/api/clients/sub-filter', {
                params:
                    {
                        by: value,
                    }
            })
                .then(({data}) => {
                    this.getClientsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/clients/sub-filter?by=' + value + '&page=';
                })
                .catch((response) => this.getClientsListErrorResponse(response));
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/clients', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getClientsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/clients?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getClientsListErrorResponse(response));
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/clients/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getClientsListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getClients();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getClients() {
            this.search = null;
            this.isLoading = true;
            this.activeItem = null;
            axios.get('/api/clients')
                .then(({data}) => {
                    this.getClientsListSuccessResponse(data);
                    this.endpoint = '/api/clients?page=';
                })
                .catch((response) => this.getClientsListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getProducts();
            } else {
                axios.get('/api/clients/search=' + this.search)
                    .then(({data}) => {
                        this.getClientsListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/clients/search/' + this.search + '?page=';
                    })
                    .catch((response) => this.getClientsListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getClientsListSuccessResponse(data) {
            this.isLoading = false;
            this.clients = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getClientsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getClientsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Видалити?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/clients/destroy/' + id)
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
                this.clients.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
    }
}
</script>
