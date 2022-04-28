<template>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button"
                        type="button"
                        @click="showAccordion1Func"
                        :class="{'collapsed' : !showAccordion1,'collaps' : showAccordion1}"

                >
                    {{ textDeliveryAndPayment }}
                </button>
            </h2>
            <div id="collapseOne"
                 class="accordion-collapse collapse "
                 :class="{'show': showAccordion1 }"
            >
                <div class="accordion-body">
                    <div v-if="lang === 'ua'" v-html="textDeliveryAndPaymentUa"></div>
                    <div v-if="lang === 'ru'" v-html="textDeliveryAndPaymentRu"></div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button"
                        type="button"
                        @click="showAccordion2Func"
                        :class="{'collapsed' : !showAccordion2,'collaps' : showAccordion2}"
                >
                    {{ textReturnAndExchange }}
                </button>
            </h2>
            <div id="collapseTwo"
                 class="accordion-collapse collapse"
                 :class="{'show': showAccordion2 }"
            >
                <div class="accordion-body">
                    <div v-if="lang === 'ua'" v-html="textReturnAndExchangeUa"></div>
                    <div v-if="lang === 'ru'" v-html="textReturnAndExchangeRu"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showAccordion1: false,
            showAccordion2: false,
        }
    },
    props: {
        textDeliveryAndPayment: String,
        textReturnAndExchange: String,
        textDeliveryAndPaymentRu: String,
        textDeliveryAndPaymentUa: String,
        textReturnAndExchangeRu: String,
        textReturnAndExchangeUa: String,
        lang: String,
    },
    methods: {
        showAccordion1Func() {
            this.showAccordion1 = !this.showAccordion1;
        },
        showAccordion2Func() {
            this.showAccordion2 = !this.showAccordion2;
        }
    }
}
</script>
