<template>
    <div>
        <div class="row">
            <div class="col">
                <a v-bind:href="'/admin/bookkeeping/managers-salaries/create/'">
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
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Всего заявок:
                </div>
                <div class="h6">
                    {{ sumApplications }}
                </div>
            </div>
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Всего доп.продаж:
                </div>
                <div class="h6">
                    {{ sumAdditionalSales }}
                </div>
            </div>
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Отмененных заявок:
                </div>
                <div class="h6">
                    {{ sumCanceledApplications }}
                </div>
            </div>
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Сумма за заявки:
                </div>
                <div class="h6">
                    {{ sumPriceApplications | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Сумма за доп.продажи:
                </div>
                <div class="h6">
                    {{ sumAdditionalSalesMarginality | formatMoney }}
                </div>
            </div>
            <div class="col-6 col-md-4 text-center my-3">
                <div class="h5">
                    Итого:
                </div>
                <div class="h6">
                    {{ sumTotalPrice | formatMoney }}
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
                            <th>Всего заявок</th>
                            <th>Отмененных заявок</th>
                            <th>Выполненных заявок</th>
                            <th>Дополнительные продажи</th>
                            <th>Сумма за заявки</th>
                            <th>Сумма за доп.продажи</th>
                            <th>Общая сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in managersSalaries" :key="item.id">
                            <th>{{ item.date | moment("DD.MM.YYYY") }}</th>
                            <th>{{ item.applications }}</th>
                            <th>{{ item.canceled_applications }}</th>
                            <th>{{ item.done_applications }}</th>
                            <th>{{ item.additional_sales }}</th>
                            <th>{{ item.sum_price_applications | formatMoney }}</th>
                            <th>{{ item.sum_price_additional_sales | formatMoney }}</th>
                            <th>{{ item.total_price |formatMoney }}</th>
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
            managersSalaries: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/managers-salaries?page=',
            sumApplications: null,
            sumAdditionalSales: null,
            sumPriceApplications: null,
            sumCanceledApplications: null,
            sumAdditionalSalesMarginality: null,
            sumTotalPrice: null,

            date: new Date(),
            currentDate: new Date(),
        }
    },
    mounted() {
        this.showAllStatistics();
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
            axios.get("/api/bookkeeping/managers-salaries")
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        showStatisticsFor7Days() {
            axios.get("/api/bookkeeping/managers-salaries/?days=7")
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        showStatisticsFor14Days() {
            axios.get("/api/bookkeeping/managers-salaries/?days=14")
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        showStatisticsFor30Days() {
            axios.get("/api/bookkeeping/managers-salaries/?days=30")
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        getManagerSalariesSuccessResponse(data) {
            this.managersSalaries = data.result.all.data;
            console.log(this.managersSalaries);
            this.sumApplications = data.result.sumApplications;
            this.sumAdditionalSales = data.result.sumAdditionalSales;
            this.sumPriceApplications = data.result.sumPriceApplications;
            this.sumCanceledApplications = data.result.sumCanceledApplications;
            this.sumAdditionalSalesMarginality = data.result.sumAdditionalSalesMarginality;
            this.sumTotalPrice = data.result.sumTotalPrice;

            this.total = data.result.all.total;
            this.currentPage = data.result.all.current_page;
            this.perPage = data.result.all.per_page;
        },
        getManagerSalariesErrorResponse(response) {
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
