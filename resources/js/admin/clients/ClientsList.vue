<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getClients">Очистити</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Пошук</button>
                    </div>
                </div>
            </div>
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
                                <div class="mr-1">Ім`я</div>
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
                                <div class="mr-1">Номер телефону</div>
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
                                <div class="mr-1">Кіль-сть покупок</div>
                                <a href="javascript:" class="text-dark" @click="sort('number_of_purchases','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('number_of_purchases','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Середній чек</div>
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
                                <div class="mr-1">Загальний чек</div>
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
                                <div class="mr-1">Створено</div>
                                <a href="javascript:" class="text-dark" @click="sort('created_at','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('created_at','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                            <hr class="m-1">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Оновлено</div>
                                <a href="javascript:" class="text-dark" @click="sort('updated_at','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('updated_at','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>Дії</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-if="clients.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Кліентів ще нема</div>
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
                        <td><a :href="'/admin/clients/edit/' + client.id">{{ client.name }}</a></td>
                        <td><a :href="'tel:' + client.phone">{{ client.phone }}</a></td>
                        <td>{{ client.number_of_purchases }}</td>
                        <td>{{ client.average_check }}</td>
                        <td>{{ client.whole_check }}</td>
                        <td>
                            {{ dateFormat(client.created_at) }}
                            <hr class="m-1">
                            {{ dateFormat(client.updated_at) }}
                        </td>
                        <td>
                            <a v-bind:href="'/admin/clients/edit/' + client.id">
                                <edit-icon></edit-icon>
                            </a>
                            <a href="javascript:" @click="onDelete(client.id)">
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
                                <option :value="null">Виберіть дію</option>
                                <option :value="destroyMassAction">Видалити</option>
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
</template>

<script>
export default {
    beforeCreate() {
        this.isLoading = true;
    },
    props: {
        destroyMassAction: String,
    },
    data() {
        return {
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            clients: [],
            isLoading: true,
            endpoint: '/api/clients?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getClients();
    },
    methods: {
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
