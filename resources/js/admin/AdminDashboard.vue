<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="h3">Текущее время: {{ timeNow }}</div>
                <div class="h3">Заказов сегодня: {{ ordersToday }}</div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            timeNow: null,
            ordersToday: null,
        }
    },
    created() {
        setInterval(this.getTimeNow, 1000);
    },
    mounted() {
        axios.get("/api/dashboard")
            .then(({data}) => this.ordersToday = data.ordersToday)
            .catch((response) => console.log(response));
    },
    methods: {
        getTimeNow: function () {
            const today = new Date();
            this.timeNow = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        }
    }
}
</script>
