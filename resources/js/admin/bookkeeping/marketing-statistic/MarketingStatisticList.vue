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
                            @click="getAllMarketingStatistics"
                            :class="{'active': activeLastDays === null}"
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
            <div class="row">
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getStatisticsByLastDays('7-days')"
                            :class="{'active': activeLastDays === '7-days'}"
                    >7 дней
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getStatisticsByLastDays('14-days')"
                            :class="{'active': activeLastDays === '14-days'}"
                    >14 дней
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getStatisticsByLastDays('30-days')"
                            :class="{'active': activeLastDays === '30-days'}"
                    >30 дней
                    </button>
                </div>
                <div class="col-12 col-md-3 my-2">
                    <button class="btn btn-outline-danger w-100 h-100"
                            @click="getStatisticsByLastDays('90-days')"
                            :class="{'active': activeLastDays === '90-days'}"
                    >90 дней
                    </button>
                </div>
            </div>
            <hr>
            <div>
                <apexchart type="area" height="350" :options="options"
                           :series="series"></apexchart>
            </div>
            <hr>
            <div class="row align-items-center justify-content-center">
                <hr>
                <div class="col-6 col-md-3 text-center my-1" v-for="(item,i) in generalMarketingStatistics">
                    <bookkeeping-statistics-card
                        v-if="i !== 'Ср.кол-во товара'"
                        type="money"
                        :title="i"
                        :value="item"
                    ></bookkeeping-statistics-card>
                    <bookkeeping-statistics-card
                        v-else
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
                                <th>Ср.цена заявки</th>
                                <th>Ср.цена апрува</th>
                                <th>Ср.цена выполненной заявки</th>
                                <th>Ср.чек</th>
                                <th>Ср.маржа</th>
                                <th>Ср.кол-во товаров</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in marketingStatistics" :key="item.id">
                                <th>{{ item.date | moment("DD.MM.YYYY") }}</th>
                                <td>{{ item.average_application_price | formatMoney }} грн.</td>
                                <td>{{ item.average_approve_application_price | formatMoney}} грн.</td>
                                <td>{{ item.average_done_application_price | formatMoney}} грн.</td>
                                <td>{{ item.average_check | formatMoney}} грн.</td>
                                <td>{{ item.average_marginality | formatMoney}} грн.</td>
                                <td>{{ item.average_items }} шт.</td>
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
            marketingStatistics: [],
            generalMarketingStatistics: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/marketing-statistic?page=',
            date: null,
            currentDate: new Date(),
            activeLastDays: null,
            series: [],
            options: {
                xaxis: {
                    labels: {
                        rotate: -15,
                        rotateAlways: true,
                    },
                },
                chart: {
                    id: 'options-marketing-statistic-chart',
                    type: 'area',
                    stacked: true,
                    height: 450,
                    zoom: {
                        enabled: true,
                        type: 'x',
                        autoScaleYaxis: true
                    },
                },
                markers: {
                    size: 0,
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
            },
        }
    },
    mounted() {
        this.getStatisticsByLastDays('7-days');
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
        getAllMarketingStatistics() {
            this.isLoading = true;
            this.activeLastDays = null;
            this.date = null;
            axios.get("/api/bookkeeping/marketing-statistic")
                .then(({data}) => this.getMarketingStatisticSuccessResponse(data))
                .catch((response) => this.getMarketingStatisticErrorResponse(response));
        },
        getStatisticsByLastDays(days) {
            this.isLoading = true;
            this.activeLastDays = days;
            this.date = null;
            axios.get("/api/bookkeeping/marketing-statistic", {
                params: {
                    last: days
                }
            })
                .then(({data}) => this.getMarketingStatisticSuccessResponse(data))
                .catch((response) => this.getMarketingStatisticErrorResponse(response));
        },
        getMarketingStatisticSuccessResponse(data) {
            this.marketingStatistics = data.result.data;
            this.generalMarketingStatistics = data.generalStat;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;

            this.series = [
                {
                    name: 'Ср.цена заявки',
                    data: []
                },
                {
                    name: 'Ср.цена апрува',
                    data: []
                },
                {
                    name: 'Ср.цена выполненной заявки',
                    data: []
                },
                {
                    name: 'Ср.чек',
                    data: []
                },
                {
                    name: 'Ср.маржа',
                    data: []
                },
                {
                    name: 'Ср.кол-во товара',
                    data: []
                }];
            let average_application_price = this.series.find((item) => item.name === 'Ср.цена заявки');
            let average_approve_application_price = this.series.find((item) => item.name === 'Ср.цена апрува');
            let average_done_application_price = this.series.find((item) => item.name === 'Ср.цена выполненной заявки');
            let average_check = this.series.find((item) => item.name === 'Ср.чек');
            let average_marginality = this.series.find((item) => item.name === 'Ср.маржа');
            let average_items = this.series.find((item) => item.name === 'Ср.кол-во товара');

            const self = this;
            self.options.xaxis.categories = [];
            data.chart.forEach((item) => {
                average_application_price.data.unshift(item.average_application_price);
                average_done_application_price.data.unshift(item.average_done_application_price);
                average_approve_application_price.data.unshift(item.average_approve_application_price);
                average_check.data.unshift(item.average_check);
                average_marginality.data.unshift(item.average_marginality);
                average_items.data.unshift(item.average_items);
                self.options.xaxis.categories.unshift(self.dateFormat(item.date));
            })
            self.series = [average_application_price, average_done_application_price, average_approve_application_price, average_check, average_marginality, average_items];
            self.isLoading = false;
        },
        getMarketingStatisticErrorResponse(response) {
            console.log(response);
        },
        fetch(page = 1) {
            axios.get(this.endpoint + page)
                .then(({data}) => this.getMarketingStatisticSuccessResponse(data));
        },
        searchByRange() {
            this.isLoading = true;
            this.activeLastDays = null;
            axios.get("/api/bookkeeping/marketing-statistic", {
                params: {
                    date_start: this.date.start,
                    date_end: this.date.end
                }
            })
                .then(({data}) => this.getMarketingStatisticSuccessResponse(data))
                .catch((response) => this.getMarketingStatisticErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        }
    }
}
</script>
