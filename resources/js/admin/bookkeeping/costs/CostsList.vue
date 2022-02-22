<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col-12">
                    <h2>Расходы</h2>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 col-md-2">
                    <a href="/admin/bookkeeping/costs/create" class="mb-3">
                        <button class="btn btn-danger my-2 w-100"
                        >Добавить расход
                        </button>
                    </a>
                </div>

                <div class="col-12 col-md-2">
                    <a href="/admin/bookkeeping/costs/categories" class="mb-3">
                        <button class="btn btn-danger my-2 w-100"
                        >Редактировать категории
                        </button>
                    </a>
                </div>
                <div class="col-12 col-md-8 my-auto">
                    <form @submit.prevent="searchByRange" class="d-flex">
                        <VueDatePicker
                            v-model="date"
                            format="YYYY-MM-DD"
                            placeholder="Введите дату"
                            range/>

                        <button type="submit" class="btn btn-danger">Поиск</button>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getCosts"
                            :class="{'active': activeLastDays === 'all'}"
                    >За все время
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getCostsByLast('week')"
                            :class="{'active': activeLastDays === 'week'}"
                    >Текущая неделя
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getCostsByLast('two-week')"
                            :class="{'active': activeLastDays === 'two-week'}"
                    >Текущая и прошлая недели
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getCostsByLast('one-month')"
                            :class="{'active': activeLastDays === 'one-month'}"
                    >Текущий месяц
                    </button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-2" v-for="(item,i) in generalStat" :key="i">
                    <bookkeeping-statistics-card
                        type="money"
                        :title="i"
                        :value="item"
                    ></bookkeeping-statistics-card>
                </div>
            </div>
            <hr>
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
                            <th>Категория</th>
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
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Добавить расход
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="cost in costs" :key="cost.id" style="vertical-align: middle;">
                            <td>{{ dateFormat(cost.date) }}</td>
                            <td>
                                <a :href="'/admin/bookkeeping/costs/edit/' + cost.id">
                                    {{ cost.category.title }}
                                </a>
                            </td>
                            <td>{{ cost.quantity }} шт.</td>
                            <td>{{ cost.sum | formatMoney }} грн.</td>
                            <td>{{ cost.total | formatMoney }} грн.</td>
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
            generalStat: {},
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
            date: new Date(),
            currentDate: new Date(),
            activeLastDays: 'all',

        }
    },
    mounted() {
        this.getCosts();
    },
    props: {
        destroyMassAction: String,
    },
    methods: {
        getCostsByLast(value) {
            this.isLoading = true;
            this.date = new Date();
            axios.get('/api/bookkeeping/costs', {
                params: {
                    last: value,
                }
            })
                .then(({data}) => {
                    this.getCostsListSuccessResponse(data);
                    this.activeLastDays = value;
                    this.endpoint = '/api/bookkeeping/costs?last=' + value + '&page=';
                })
                .catch((response) => this.getCostsListErrorResponse(response));
        },
        searchByRange() {
            this.isLoading = true;
            axios.get('/api/bookkeeping/costs', {
                params: {
                    date_start: this.date.start,
                    date_end: this.date.end
                }
            })
                .then(({data}) => {
                    this.getCostsListSuccessResponse(data);
                    this.activeLastDays = null;
                    this.endpoint = '/api/bookkeeping/costs?date_start=' + this.date.start + '&date_end=' + this.date.end + '&page=';
                })
                .catch((response) => this.getCostsListErrorResponse(response));
        },
        getCosts() {
            this.search = null;
            this.isLoading = true;
            this.date = new Date();
            axios.get('/api/bookkeeping/costs')
                .then(({data}) => {
                    this.activeLastDays = 'all';
                    this.getCostsListSuccessResponse(data);
                    this.endpoint = '/api/bookkeeping/costs?page=';
                })
                .catch((response) => this.getCostsListErrorResponse(response));
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
            this.generalStat = data.generalStat;
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
