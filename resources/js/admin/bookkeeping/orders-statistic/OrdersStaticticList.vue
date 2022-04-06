<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row">
                <div class="col">
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
            <div class="row">
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getAllOrdersStatistics"
                            :class="{'active': activeLastDays === 'all'}"
                    >За все время
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getStatisticsByLastDays('week')"
                            :class="{'active': activeLastDays === 'week'}"
                    >Текущая неделя
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getStatisticsByLastDays('two-week')"
                            :class="{'active': activeLastDays === 'two-week'}"
                    >Текущая и прошлая недели
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="btn btn-outline-danger my-2 w-100"
                            @click="getStatisticsByLastDays('one-month')"
                            :class="{'active': activeLastDays === 'one-month'}"
                    >Текущий месяц
                    </button>
                </div>
            </div>
            <hr>
            <div>
                <apexchart type="area" height="350" :options="optionsOrdersStatistic"
                           :series="seriesOrdersStatistic"></apexchart>
            </div>
            <hr>
            <div class="row align-items-center justify-content-center">

                <hr>
                <div class="col-6 col-md-3 text-center my-1" v-for="(item,i) in generalOrderStatistics">
                    <bookkeeping-statistics-card
                        type="quantity"
                        :title="i"
                        :value="item"
                    ></bookkeeping-statistics-card>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Всего</th>
                                <th>Новые</th>
                                <th>В процессе</th>
                                <th>Переданы поставщику</th>
                                <th>На почте</th>
                                <th>Отмененные</th>
                                <th>Возвраты</th>
                                <th>Выполненные</th>
                                <th>Ожидают отправки</th>
                                <th>Ожидают предоплаты</th>
                                <th>В дороге</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in ordersStatistics" :key="item.id">
                                <th>{{ item.date | moment("DD.MM.YYYY") }}</th>
                                <td>{{ item.applications }}</td>
                                <td>{{ item.unprocessed }}</td>
                                <td>{{ item.in_process }}</td>
                                <td>{{ item.transferred_to_supplier }}</td>
                                <td>{{ item.at_the_post_office }}</td>
                                <td>{{ item.cancel }}</td>
                                <td>{{ item.refunds }}</td>
                                <td>{{ item.completed }}</td>
                                <td>{{ item.awaiting_dispatch }}</td>
                                <td>{{ item.awaiting_prepayment }}</td>
                                <td>{{ item.on_the_road }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col">
                                <pagination
                                    v-model="currentPage"
                                    :records="total"
                                    :per-page="perPage"
                                    @paginate="fetch"
                                    :options="this.$paginateOptions"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            ordersStatistics: [],
            generalOrderStatistics: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/orders-statistics?page=',
            date: null,
            currentDate: new Date(),
            activeLastDays: null,
            seriesOrdersStatistic: [],
            optionsOrdersStatistic: {
                xaxis: {
                    labels: {
                        rotate: -15,
                        rotateAlways: true,
                    },
                },
                chart: {
                    id: 'options-orders-statistic-chart',
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
        this.getAllOrdersStatistics();
    },
    computed: {
        minDate() {
            return new Date(
                this.currentDate.getFullYear() - 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate()
            );
        },
        maxDate() {
            return new Date(
                this.currentDate.getFullYear() + 1,
                this.currentDate.getMonth(),
                this.currentDate.getDate(),
            );
        },
    },
    methods: {
        getAllOrdersStatistics() {
            this.activeLastDays = null;
            this.date = null;
            axios.get("/api/bookkeeping/orders-statistics")
                .then(({data}) => this.getOrdersStatisticSuccessResponse(data))
                .catch((response) => this.getOrdersStatisticErrorResponse(response));
        },
        getStatisticsByLastDays(days) {
            this.activeLastDays = days;
            this.date = null;
            axios.get("/api/bookkeeping/orders-statistics", {
                params: {
                    last: days
                }
            })
                .then(({data}) => this.getOrdersStatisticSuccessResponse(data))
                .catch((response) => this.getOrdersStatisticErrorResponse(response));
        },
        getOrdersStatisticSuccessResponse(data) {
            this.ordersStatistics = data.result.data;
            this.generalOrderStatistics = data.generalStatistics;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;

            this.seriesOrdersStatistic = [
                {
                    name: 'Всего заявок',
                    data: []
                },
                {
                    name: 'Выполненные',
                    data: []
                },
                {
                    name: 'Возвраты',
                    data: []
                },
                {
                    name: 'Отмененные',
                    data: []
                }];
            let applications = this.seriesOrdersStatistic.find((item) => item.name === 'Всего заявок');
            let completed = this.seriesOrdersStatistic.find((item) => item.name === 'Выполненные');
            let refunds = this.seriesOrdersStatistic.find((item) => item.name === 'Возвраты');
            let cancel = this.seriesOrdersStatistic.find((item) => item.name === 'Отмененные');

            const self = this;
            self.ordersStatistics.forEach((item) => {
                applications.data.unshift({y: item.applications, x: self.dateFormat(item.date)});
                completed.data.unshift({y: item.completed, x: self.dateFormat(item.date)});
                refunds.data.unshift({y: item.refunds, x: self.dateFormat(item.date)});
                cancel.data.unshift({y: item.cancel, x: self.dateFormat(item.date)});
            })
            self.seriesOrdersStatistic = [applications, completed, refunds, cancel];
            self.isLoading = false;
        },
        getOrdersStatisticErrorResponse(response) {
            console.log(response);
        },
        fetch(page = 1) {
            axios.get(this.endpoint + page)
                .then(({data}) => this.getOrdersStatisticSuccessResponse(data));
        },
        searchByRange() {
            this.activeLastDays = null;
            axios.get("/api/bookkeeping/orders-statistics", {
                params: {
                    date_start: this.date.start,
                    date_end: this.date.end
                }
            })
                .then(({data}) => this.getOrdersStatisticSuccessResponse(data))
                .catch((response) => this.getOrdersStatisticErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        }
    }
}
</script>
