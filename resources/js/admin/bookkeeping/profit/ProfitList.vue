<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h2>Прибыль</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <button class="btn btn-danger"
                            @click="createProfit"
                    >
                        Добавить день
                    </button>
                </div>
                <div class="col-12 col-md-6">
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
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getProfits"
                            :class="{'active': activeLastDays === 'all'}"
                    >Вся статистика
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getProfitsByLast('week')"
                            :class="{'active': activeLastDays === 'week'}"
                    >Текущая неделя
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getProfitsByLast('two-week')"
                            :class="{'active': activeLastDays === 'two-week'}"
                    >Текущая и прошлая недели
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getProfitsByLast('one-month')"
                            :class="{'active': activeLastDays === 'one-month'}"
                    >Текущий месяц
                    </button>
                </div>
            </div>
            <hr>
            <div>
                <apexchart type="area" height="350" :options="options" :series="series"></apexchart>
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-12 col-md-3 my-2" v-for="(item,i) in generalStat" :key="i">
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
                                    <div class="mr-1">Сумма за возвраты</div>
                                    <a href="javascript:" class="text-dark" @click="sort('refunds_sum','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('refunds_sum','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Прибыль без затрат</div>
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
                                    <div class="mr-1">Продажи воздуха</div>
                                    <a href="javascript:" class="text-dark" @click="sort('sale_of_air_sum','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('sale_of_air_sum','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Прибыль без продаж воздуха</div>
                                    <a href="javascript:" class="text-dark" @click="sort('sale_of_air_sum','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('sale_of_air_sum','desc')">
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
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Чистая прибыль</div>
                                    <a href="javascript:" class="text-dark" @click="sort('clear_profit','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('clear_profit','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-for="profit in profits" :key="profit.id" style="vertical-align: middle;">
                            <td>{{ dateFormat(profit.date) }}</td>
                            <td>{{ profit.cost | formatMoney }} грн.</td>
                            <td>{{ profit.refunds_sum | formatMoney }} грн.</td>
                            <td>{{ profit.profit | formatMoney }} грн.</td>
                            <td>{{ profit.sale_of_air_sum | formatMoney }} грн.</td>
                            <td>{{ profit.profit_without_sale_of_air | formatMoney }} грн.</td>
                            <td>{{ profit.turnover | formatMoney }} грн.</td>
                            <td>{{ profit.clear_profit | formatMoney }} грн.</td>
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
            generalStat: {},
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
            date: new Date(),
            currentDate: new Date(),
            activeLastDays: null,
            series: [],
            options: {
                xaxis: {
                    categories: [],
                    labels: {
                        rotate: -15,
                        rotateAlways: true,
                    }
                },
                chart: {
                    type: 'area',
                    stacked: false,
                    height: 350,
                    zoom: {
                        enabled: false,
                        autoScaleYaxis: true
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
            },
        }
    },
    mounted() {
        this.getProfits();
    },
    props: {
        destroyMassAction: String,
    },
    methods: {
        getProfitsByLast(value) {
            this.isLoading = true;
            this.date = new Date();
            axios.get('/api/bookkeeping/profits', {
                params: {
                    last: value,
                }
            })
                .then(({data}) => {
                    this.getProfitsListSuccessResponse(data);
                    this.activeLastDays = value;
                    this.endpoint = '/api/bookkeeping/profits?last=' + value + '&page=';
                })
                .catch((response) => this.getProfitsListErrorResponse(response));
        },
        searchByRange() {
            this.isLoading = true;
            axios.get('/api/bookkeeping/profits', {
                params: {
                    date_start: this.date.start,
                    date_end: this.date.end
                }
            })
                .then(({data}) => {
                    this.getProfitsListSuccessResponse(data);
                    this.activeLastDays = null;
                    this.endpoint = '/api/bookkeeping/profits?date_start=' + this.date.start + '&date_end=' + this.date.end + '&page=';
                })
                .catch((response) => this.getProfitsListErrorResponse(response));
        },
        getProfits() {
            this.search = null;
            this.isLoading = true;
            this.date = new Date();
            axios.get('/api/bookkeeping/profits')
                .then(({data}) => {
                    this.getProfitsListSuccessResponse(data);
                    this.activeLastDays = 'all';
                    this.endpoint = '/api/bookkeeping/profits?page=';
                })
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
            this.generalStat = data.generalStat;

            this.series = [
                {
                    name: 'Расходы',
                    data: []
                },
                {
                    name: 'Прибыль без расходов',
                    data: []
                },
                {
                    name: 'Чистая прибыль',
                    data: []
                },
                {
                    name: 'Оборот',
                    data: []
                },
                {
                    name: 'Сумма за возвраты',
                    data: []
                },
                {
                    name: 'Продажи воздуха',
                    data: []
                },
                {
                    name: 'Прибыль без продаж воздуха',
                    data: []
                }];
            let costs = this.series.find((item) => item.name === 'Расходы');
            let profits = this.series.find((item) => item.name === 'Прибыль без расходов');
            let clear_profit = this.series.find((item) => item.name === 'Чистая прибыль');
            let turnover = this.series.find((item) => item.name === 'Оборот');
            let refunds_sum = this.series.find((item) => item.name === 'Сумма за возвраты');
            let sale_of_air_sum = this.series.find((item) => item.name === 'Продажи воздуха');
            let profit_without_sale_of_air = this.series.find((item) => item.name === 'Прибыль без продаж воздуха');

            const self = this;
            data.result.data.forEach((item) => {
                costs.data.unshift({y: item.cost, x: self.dateFormat(item.date)});
                clear_profit.data.unshift({y: item.clear_profit, x: self.dateFormat(item.date)});
                profits.data.unshift({y: item.profit, x: self.dateFormat(item.date)});
                turnover.data.unshift({y: item.turnover, x: self.dateFormat(item.date)});
                refunds_sum.data.unshift({y: item.refunds_sum, x: self.dateFormat(item.date)});
                sale_of_air_sum.data.unshift({y: item.sale_of_air_sum, x: self.dateFormat(item.date)});
                profit_without_sale_of_air.data.unshift({
                    y: item.profit_without_sale_of_air,
                    x: self.dateFormat(item.date)
                });
            })
            self.series = [costs, clear_profit, profits, turnover, refunds_sum, sale_of_air_sum, profit_without_sale_of_air];
            self.isLoading = false;
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
