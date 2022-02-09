<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="costs.length"
                            @click="createCost"
                    >
                        Добавить расход
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-center">
                        <tr style="vertical-align: middle;">
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Дата</div>
                                    <a href="javascript:" class="text-dark" @click="sort('date','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('date','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Категория</div>
                                    <a href="javascript:" class="text-dark" @click="sort('name','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('name','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>Кол-во</th>
                            <th>Сумма</th>
                            <th>Итого</th>
                            <th>Ответственный</th>
                            <th>Комментарий</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-if="costs.length === 0">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Расходы не добавлены</div>
                                    <button
                                        @click="createCost"
                                        class="btn btn-primary w-25 m-auto"
                                    >
                                        Добавить расход
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="cost in costs" :key="cost.id" style="vertical-align: middle;">
                            <td>{{ dateFormat(cost.date) }}</td>
                            <td>{{ cost.name }}</td>
                            <td>{{ cost.quantity }}</td>
                            <td>{{ cost.sum | formatMoney }}</td>
                            <td>{{ cost.total | formatMoney }}</td>
                            <td>{{ cost.user ? cost.user.name : '-' }}</td>
                            <td>{{ cost.comment ? cost.comment.substr(0, 30) + '...' : '-' }}</td>
                            <td>
                                <a :href="'/admin/bookkeeping/costs/edit/' + cost.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(cost.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="costs.length !== 0">
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
</template>

<script>
export default {
    data() {
        return {
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            search: null,
            costs: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/costs?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getCosts();
    },
    props: {
        destroyMassAction: String,
    },
    methods: {
        getCosts() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/bookkeeping/costs')
                .then(({data}) => this.getCostsListSuccessResponse(data))
                .catch((response) => this.getCostsListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getCategories();
            } else {
                axios.get('/api/bookkeeping/costs/search/' + this.search)
                    .then(({data}) => {
                        this.getCostsListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/bookkeeping/costs/search/' + this.search + '?page=';
                    })
                    .catch((response) => this.getCostsListErrorResponse(response));
            }

        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/bookkeeping/costs', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getCostsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/bookkeeping/costs?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getCostsListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getCostsListSuccessResponse(data) {
            this.costs = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getCostsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getCostsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/bookkeeping/costs/destroy/' + id)
                        .then(() => {
                            this.fetch(1);
                            this.$swal({
                                title: 'Удалено!',
                                icon: 'success',
                                showCancelButton: false,
                            });
                        })
                        .catch((response) => {
                            console.log(response);
                            this.$swal({
                                title: 'Ошибка',
                                icon: 'error',
                                showCancelButton: false,
                            });
                        });
                }
            });
        },
        createCost() {
            window.location.href = '/admin/bookkeeping/costs/create';
        }
    },
}
</script>
