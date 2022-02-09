<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h2>Прибыль</h2>
                </div>

                <div class="col-12 col-md-6 text-end">
                    <button class="btn btn-danger"
                            @click="createProfit"
                    >
                        Добавить день
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
                                    <div class="mr-1">Сумма расходов</div>
                                    <a href="javascript:" class="text-dark" @click="sort('cost','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('cost','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Сумма прибыли</div>
                                    <a href="javascript:" class="text-dark" @click="sort('profit','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('profit','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Маржинальность</div>
                                    <a href="javascript:" class="text-dark" @click="sort('marginality','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('marginality','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Оборот</div>
                                    <a href="javascript:" class="text-dark" @click="sort('turnover','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('turnover','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-for="profit in profits" :key="profit.id" style="vertical-align: middle;">
                            <td>{{ dateFormat(profit.date) }}</td>
                            <td>{{ profit.cost | formatMoney}} грн.</td>
                            <td>{{ profit.profit | formatMoney}} грн.</td>
                            <td>{{ profit.marginality | formatMoney}} грн.</td>
                            <td>{{ profit.turnover | formatMoney}} грн.</td>
                        </tr>
                        </tbody>
                        <tfoot v-if="profits.length !== 0">
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
            profits: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/profits?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getProfits();
    },
    props: {
        destroyMassAction: String,
    },
    methods: {
        getProfits() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/bookkeeping/profits')
                .then(({data}) => this.getProfitsListSuccessResponse(data))
                .catch((response) => this.getProfitsListErrorResponse(response));
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/bookkeeping/profits', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getProfitsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/bookkeeping/profits?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getProfitsListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getProfitsListSuccessResponse(data) {
            this.profits = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getProfitsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getProfitsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/bookkeeping/profits/destroy/' + id)
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
        createProfit() {
            window.location.href = '/admin/bookkeeping/profits/create';
        }
    },
}
</script>
