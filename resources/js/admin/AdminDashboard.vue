<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="h3">Текущее время: {{ timeNow }}</div>
                <div class="h3">Заказов сегодня: {{ ordersToday }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <bookkeeping-daily-statistics></bookkeeping-daily-statistics>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            clients: [],
            orders: [],
            dailyStatistics: [],
            timeNow: null,
            ordersToday: null,
        }
    },
    created() {
        setInterval(this.getTimeNow, 1000);
    },
    mounted() {
        axios.get("/api/dashboard/")
            .then(({data}) => this.getDashboardSuccessResponse(data))
            .catch((response) => this.getDashboardErrorResponse(response));

        axios.get("/api/clients/")
            .then(({data}) => this.getClientsListSuccessResponse(data))
            .catch((response) => this.getClientsListErrorResponse(response));

        axios.get("/api/orders/")
            .then(({data}) => this.getOrdersListSuccessResponse(data))
            .catch((response) => this.getOrdersListErrorResponse(response));

        axios.get("/api/bookkeeping/daily-statistics")
            .then(({data}) => this.getDailyStatisticsSuccessResponse(data))
            .catch((response) => this.getDailyStatisticsErrorResponse(response));
    },
    methods: {
        getDashboardSuccessResponse(data) {
            this.ordersToday = data.ordersToday;
        },
        getDashboardErrorResponse(response) {
            console.log(response);
        },

        getClientsListSuccessResponse(data) {
            this.clients = data.result.data;
        },
        getClientsListErrorResponse(response) {
            console.log(response);
        },

        getOrdersListSuccessResponse(data) {
            this.orders = data.result.data;
        },
        getOrdersListErrorResponse(response) {
            console.log(response);
        },

        getDailyStatisticsSuccessResponse(data) {
            this.dailyStatistics = data.result.data;
        },
        getDailyStatisticsErrorResponse(response) {
            console.log(response);
        },

        getTimeNow: function () {
            const today = new Date();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            this.timeNow = time;
        }
    }
}
</script>
