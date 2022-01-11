<template>
    <div>
        <div class="row">
            <div class="col">
                <a v-bind:href="'/admin/bookkeeping/daily-statistics/create/'">
                    <button type="button" class="btn btn-danger">
                        <b>Добавить день</b>
                    </button>
                </a>
            </div>
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
        <div class="row my-3">
            <div class="col">
                <button type="button"
                        class="btn btn-outline-warning"
                        @click.prevent="showAllStatistics"
                >За все время
                </button>
            </div>
            <div class="col">
                <button type="button"
                        class="btn btn-outline-warning"
                        @click.prevent="showStatisticsFor7Days"
                >За 7 дней
                </button>
            </div>
            <div class="col">
                <button type="button"
                        class="btn btn-outline-warning"
                        @click.prevent="showStatisticsFor14Days"
                >За 14 дней
                </button>
            </div>
            <div class="col">
                <button type="button"
                        class="btn btn-outline-warning"
                        @click.prevent="showStatisticsFor30Days"
                >За 30 дней
                </button>
            </div>
        </div>
        <div class="row align-items-center">
            <hr>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Получено заявок:
                </div>
                <div class="h6">
                    {{ SumApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    На почте:
                </div>
                <div class="h6">
                    {{ SumAtThePostOffice }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средний COR:
                </div>
                <div class="h6">
                    {{ AverageCorRate | formatPercent }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средний ROR:
                </div>
                <div class="h6">
                    {{ AverageRorRate | formatPercent }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средний RPR:
                </div>
                <div class="h6">
                    {{ AverageRprRate | formatPercent }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средняя цена заявки:
                </div>
                <div class="h6">
                    {{ AverageApplicationPrice | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средняя стоимость клиента:
                </div>
                <div class="h6">
                    {{ AverageClientCostRate | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Общая прибыль:
                </div>
                <div class="h6">
                    {{ SumProfit | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Затраты на рекламу:
                </div>
                <div class="h6">
                    {{ SumTargetCosts | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Средняя маржа:
                </div>
                <div class="h6">
                    {{ AverageMarginality | formatPercent }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Прибыль инвестора:
                </div>
                <div class="h6">
                    {{ SumInvestorProfit | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Зарплата менеджера:
                </div>
                <div class="h6">
                    {{ SumManagerSalary | formatMoney }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Цена заявки</th>
                            <th>Затраты на рекламу</th>
                            <th>Количество заявок</th>
                            <th>Переданы поставщику</th>
                            <th>Ожидают отправки</th>
                            <th>Ожидают предоплаты</th>
                            <th>В дороге</th>
                            <th>В процессе</th>
                            <th>На почте</th>
                            <th>Выполненные</th>
                            <th>Возвраты</th>
                            <th>Отмененные</th>
                            <th>Не обработаны</th>
                            <th>Canceled Orders Rate</th>
                            <th>Returned Orders Ratio</th>
                            <th>Received Parcel Ratio</th>
                            <th>Стоимость клиента</th>
                            <th>Прибыль</th>
                            <th>Расходы</th>
                            <th>Чистая прибыль</th>
                            <th>Маржинальность</th>
                            <th>Прибыль инвестора</th>
                            <th>Зарплата менеджера</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in dailyStatistics" :key="item.id">
                            <th>{{ item.date | moment("DD.MM.YYYY") }}</th>
                            <th>{{ item.application_price | formatMoney }}</th>
                            <td>{{ item.advertising }}</td>
                            <td>{{ item.applications }}</td>
                            <td>{{ item.transferred_to_supplier }}</td>
                            <td>{{ item.awaiting_dispatch }}</td>
                            <td>{{ item.awaiting_prepayment }}</td>
                            <td>{{ item.on_the_road }}</td>
                            <td>{{ item.in_process }}</td>
                            <td>{{ item.at_the_post_office }}</td>
                            <td>{{ item.completed_applications }}</td>
                            <td>{{ item.refunds }}</td>
                            <td>{{ item.cancel }}</td>
                            <td>{{ item.unprocessed }}</td>
                            <td>{{ item.canceled_orders_rate | formatPercent }}</td>
                            <td>{{ item.returned_orders_ratio | formatPercent }}</td>
                            <td>{{ item.received_parcel_ratio | formatPercent }}</td>
                            <td>{{ item.client_cost | formatMoney }}</td>
                            <td>{{ item.profit | formatMoney }}</td>
                            <td>{{ item.costs | formatMoney }}</td>
                            <td>{{ item.net_profit | formatMoney }}</td>
                            <td>{{ item.marginality | formatPercent }}</td>
                            <td>{{ item.investor_profit | formatMoney }}</td>
                            <td>{{ item.manager_salary | formatMoney }}</td>
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
</template>

<script>
export default {
    data() {
        return {
            dailyStatistics: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/daily-statistics?page=',
            SumApplications: 1,
            SumAtThePostOffice: 1,
            AverageCorRate: 1,
            AverageRorRate: 1,
            AverageRprRate: 1,
            AverageApplicationPrice: 1,
            AverageClientCostRate: 1,
            SumProfit: 1,
            SumTargetCosts: 1,
            AverageMarginality: 1,
            SumInvestorProfit: 1,
            SumManagerSalary: 1,
            date: new Date(),
            currentDate: new Date(),
        }
    },
    mounted() {
        axios.get("/api/bookkeeping/daily-statistics")
            .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
            .catch((response) => this.getDailyStatisticsErrorResponse(response));
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
        showAllStatistics() {
            axios.get("/api/bookkeeping/daily-statistics")
                .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
                .catch((response) => this.getDailyStatisticsErrorResponse(response));
        },
        showStatisticsFor7Days() {
            axios.get("/api/bookkeeping/daily-statistics/?days=7")
                .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
                .catch((response) => this.getDailyStatisticsErrorResponse(response));
        },
        showStatisticsFor14Days() {
            axios.get("/api/bookkeeping/daily-statistics/?days=14")
                .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
                .catch((response) => this.getDailyStatisticsErrorResponse(response));
        },
        showStatisticsFor30Days() {
            axios.get("/api/bookkeeping/daily-statistics/?days=30")
                .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
                .catch((response) => this.getDailyStatisticsErrorResponse(response));
        },
        getDailyStatisticsSuccessResponse(data) {
            this.dailyStatistics = data.result.data;
            this.SumApplications = data.SumApplications;
            this.SumAtThePostOffice = data.SumAtThePostOffice;
            this.AverageCorRate = data.AverageCorRate;
            this.AverageRorRate = data.AverageRorRate;
            this.AverageRprRate = data.AverageRprRate;
            this.AverageApplicationPrice = data.AverageApplicationPrice;
            this.AverageClientCostRate = data.AverageClientCostRate;
            this.SumProfit = data.SumProfit;
            this.SumTargetCosts = data.SumTargetCosts;
            this.AverageMarginality = data.AverageMarginality;
            this.SumInvestorProfit = data.SumInvestorProfit;
            this.SumManagerSalary = data.SumManagerSalary;

            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getDailyStatisticsErrorResponse(response) {
            console.log(response);
        },
        fetch(page = 1) {
            axios.get(this.endpoint + page)
                .then(({data}) => {
                    this.dailyStatistics = data.result.data;
                    this.total = data.result.total;
                    this.showingFrom = data.result.from;
                    this.showingTo = data.result.to;
                    this.pageCount = data.result.last_page;
                });
        },
        searchByRange() {
            axios.get("/api/bookkeeping/daily-statistics/date-range/", {
                params: {
                    date_start: this.date.start,
                    date_end: this.date.end
                }
            })
                .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
                .catch((response) => this.getDailyStatisticsErrorResponse(response));
        },
    }
}
</script>
