<template>
    <div class="card h-100">
        <div class="card-body text-center">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text" v-if="type === null">{{ value }}</p>
            <p class="card-text" v-if="type === 'money'">{{ value | formatMoney }} грн.</p>
            <p class="card-text" v-if="type === 'quantity'">{{ value }} шт.</p>
            <p class="card-text" v-if="type === 'percent'">{{ value }} %</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: String,
        title: String,
        value: [String, Number],
    }
}
</script>
