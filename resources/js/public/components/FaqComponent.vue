<template>
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-12 col-md-6">
                <div class="block-title mb-3">{{ textFaqHeading }}</div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item" v-for="faq in faqs" :key="faq.id">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button"
                                    type="button"
                                    @click="activeItem = faq.id"
                                    :class="{'collapsed' : activeItem !== faq.id,'collaps' : activeItem === faq.id}"

                            >
                                <span v-if="lang === 'ru'">{{ faq.question.ru }}</span>
                                <span v-if="lang === 'ua'">{{ faq.question.ua }}</span>
                            </button>
                        </h2>
                        <div id="collapseOne"
                             class="accordion-collapse collapse "
                             :class="{'show': activeItem === faq.id }"
                        >
                            <div class="accordion-body">
                                <span v-if="lang === 'ru'">{{ faq.answer.ru }}</span>
                                <span v-if="lang === 'ua'">{{ faq.answer.ua }}</span>
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
            faqs: [],
            activeItem: null,
        }
    },
    props:{
        lang: String,
        textFaqHeading: String
    },
    mounted() {
        axios.get('/api/v1/faq/list')
            .then(({data}) => this.faqs = data.result)
            .catch((response) => console.log(response))
    }
}
</script>
