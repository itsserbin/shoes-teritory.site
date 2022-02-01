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
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false" @click="showManagersDropdown">
                        {{ managersDropdownActive }}
                    </button>
                    <ul class="dropdown-menu show" aria-labelledby="dropdownMenuButton1" v-if="managersDropdown">
                        <li><a class="dropdown-item"
                               href="javascript:"
                               @click="showAllStatistics"
                        >Общая статистика</a></li>
                        <li><a class="dropdown-item"
                               href="javascript:"
                               v-for="manager in managers"
                               :key="manager.id"
                               @click="getStatByManager(manager.id,manager.name)"
                        >{{ manager.name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--        <div class="row my-3">-->
        <!--            <div class="col">-->
        <!--                <button type="button"-->
        <!--                        class="btn btn-outline-warning"-->
        <!--                        @click.prevent="showAllStatistics"-->
        <!--                >За все время-->
        <!--                </button>-->
        <!--            </div>-->
        <!--            <div class="col">-->
        <!--                <button type="button"-->
        <!--                        class="btn btn-outline-warning"-->
        <!--                        @click.prevent="showStatisticsByDays(7)"-->
        <!--                >За 7 дней-->
        <!--                </button>-->
        <!--            </div>-->
        <!--            <div class="col">-->
        <!--                <button type="button"-->
        <!--                        class="btn btn-outline-warning"-->
        <!--                        @click.prevent="showStatisticsByDays(14)"-->
        <!--                >За 14 дней-->
        <!--                </button>-->
        <!--            </div>-->
        <!--            <div class="col">-->
        <!--                <button type="button"-->
        <!--                        class="btn btn-outline-warning"-->
        <!--                        @click.prevent="showStatisticsByDays(30)"-->
        <!--                >За 30 дней-->
        <!--                </button>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="row align-items-center justify-content-center">
            <hr>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Всего заявок:
                </div>
                <div class="h6">
                    {{ countApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Отмененных заявок:
                </div>
                <div class="h6">
                    {{ sumCanceledApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Возвратов:
                </div>
                <div class="h6">
                    {{ sumReturnedApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    В процессе:
                </div>
                <div class="h6">
                    {{ countInProcessApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Выполненных заявок:
                </div>
                <div class="h6">
                    {{ sumDoneApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Общий апрув:
                </div>
                <div class="h6">
                    {{ sumTotalApplications }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Всего доп.продаж:
                </div>
                <div class="h6">
                    {{ countAdditionalSales }}
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Общая маржа доп.продаж:
                </div>
                <div class="h6">
                    {{ sumAdditionalSales | formatMoney }} грн.
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Сумма за заявки:
                </div>
                <div class="h6">
                    {{ sumPriceApplications | formatMoney }} грн.
                </div>
            </div>
            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Сумма за доп.продажи:
                </div>
                <div class="h6">
                    {{ sumPriceAdditionalSales | formatMoney }} грн.
                </div>
            </div>

            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Кол-во продаж воздуха:
                </div>
                <div class="h6">
                    {{ countSaleOfAir }}
                </div>
            </div>

            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Общая сумма продаж воздуха:
                </div>
                <div class="h6">
                    {{ sumPriceSaleOfAir | formatMoney }} грн.
                </div>
            </div>

            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Сумма за продажу воздуха:
                </div>
                <div class="h6">
                    {{ sumTotalPriceSaleOfAir | formatMoney }} грн.
                </div>
            </div>

            <div class="col-6 col-md-3 text-center my-3">
                <div class="h5">
                    Итого:
                </div>
                <div class="h6">
                    {{ sumTotalPrice | formatMoney }} грн.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table text-center" style="white-space: nowrap">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Поступило заявок</th>
                            <th>В процессе</th>
                            <th>Сделано доп.продаж</th>
                            <th>Отмененных заявок</th>
                            <th>Возвратов</th>
                            <th>Выполненных заявок</th>
                            <th>Общий апрув</th>
                            <th>Кол-во доп.продаж воздуха</th>
                            <th>Сумма доп.продаж воздуха</th>
                            <th>Прибыль с доп.продаж воздуха</th>
                            <th>Общая маржа доп.продаж</th>
                            <th>Сумма за заявки</th>
                            <th>Сумма за доп.продажи</th>
                            <th>Общая сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in managersSalaries" :key="item.id">
                            <th>{{ item.date | moment("DD.MM.YYYY") }}</th>
                            <td>{{ item.count_applications }}</td>
                            <td>{{ item.in_process_applications }}</td>
                            <td>{{ item.count_additional_sales }}</td>
                            <td>{{ item.canceled_applications }}</td>
                            <td>{{ item.returned_applications }}</td>
                            <td>{{ item.done_applications }}</td>
                            <td>{{ item.total_applications }}</td>
                            <td>{{ item.count_sale_of_air }}</td>
                            <td>{{ item.price_sale_of_air }}</td>
                            <td>{{ item.total_sale_of_air }}</td>
                            <td>{{ item.sum_additional_sales | formatMoney }} грн.</td>
                            <td>{{ item.sum_price_applications | formatMoney }} грн.</td>
                            <td>{{ item.sum_price_additional_sales | formatMoney }} грн.</td>
                            <td>{{ item.total_price |formatMoney }} грн.</td>
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
            countApplications: null,
            countAdditionalSales: null,
            sumCanceledApplications: null,
            sumDoneApplications: null,
            sumAdditionalSales: null,
            sumPriceApplications: null,
            sumPriceAdditionalSales: null,
            sumTotalPrice: null,
            countSaleOfAir: null,
            sumPriceSaleOfAir: null,
            sumTotalPriceSaleOfAir: null,
            managers: [],
            managerValue: null,
            managersDropdown: false,
            managersDropdownActive: false,
            date: new Date(),
            currentDate: new Date(),
        }
    },
    mounted() {
        this.showAllStatistics();

        axios.get('/api/users/list/managers')
            .then(({data}) => this.managers = data.result)
            .catch((response) => console.log(response))
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
        showManagersDropdown() {
            this.managersDropdown = !this.managersDropdown;
        },
        getStatByManager(value, name) {
            this.managersDropdownActive = name;
            this.managerValue = value;
            this.date = null;
            if (value !== null) {
                axios.get("/api/bookkeeping/managers-salaries", {
                    params: {
                        manager: value
                    }
                })
                    .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                    .catch((response) => this.getManagerSalariesErrorResponse(response));
            } else {
                axios.get("/api/bookkeeping/managers-salaries")
                    .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                    .catch((response) => this.getManagerSalariesErrorResponse(response));
            }
            this.showManagersDropdown();
        },
        showAllStatistics() {
            this.managersDropdownActive = 'Общая статистика';
            this.managersDropdown = false;
            this.managerValue = null;
            axios.get("/api/bookkeeping/managers-salaries")
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        showStatisticsByDays(days) {
            axios.get("/api/bookkeeping/managers-salaries", {
                params: {
                    days: days
                }
            })
                .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                .catch((response) => this.getManagerSalariesErrorResponse(response));
        },
        getManagerSalariesSuccessResponse(data) {
            this.managersSalaries = data.result.all.data;
            this.countApplications = data.result.countApplications;
            this.countAdditionalSales = data.result.countAdditionalSales;
            this.sumCanceledApplications = data.result.sumCanceledApplications;
            this.sumDoneApplications = data.result.sumDoneApplications;
            this.sumAdditionalSales = data.result.sumAdditionalSales;
            this.sumPriceApplications = data.result.sumPriceApplications;
            this.sumPriceAdditionalSales = data.result.sumPriceAdditionalSales;
            this.sumTotalPrice = data.result.sumTotalPrice;
            this.sumReturnedApplications = data.result.sumReturnedApplications;
            this.sumTotalApplications = data.result.sumTotalApplications;
            this.countInProcessApplications = data.result.countInProcessApplications;
            this.countSaleOfAir = data.result.countSaleOfAir;
            this.sumPriceSaleOfAir = data.result.sumPriceSaleOfAir;
            this.sumTotalPriceSaleOfAir = data.result.sumTotalPriceSaleOfAir;

            this.total = data.result.all.total;
            this.currentPage = data.result.all.current_page;
            this.perPage = data.result.all.per_page;
        },
        getManagerSalariesErrorResponse(response) {
            console.log(response);
        },
        fetch(page = 1) {
            axios.get(this.endpoint + page)
                .then(({data}) => this.getManagerSalariesSuccessResponse(data));
        },
        searchByRange() {
            if (this.managerValue) {
                axios.get("/api/bookkeeping/managers-salaries", {
                    params: {
                        manager: this.managerValue,
                        date_start: this.date.start,
                        date_end: this.date.end
                    }
                })
                    .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                    .catch((response) => this.getManagerSalariesErrorResponse(response));
            } else {
                axios.get("/api/bookkeeping/managers-salaries", {
                    params: {
                        date_start: this.date.start,
                        date_end: this.date.end
                    }
                })
                    .then(({data}) => this.getManagerSalariesSuccessResponse(data))
                    .catch((response) => this.getManagerSalariesErrorResponse(response));
            }
        },
    }
}
</script>
