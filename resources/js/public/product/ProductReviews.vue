<template>
    <div id="reviews" class="reviews">
        <div class="reviews__title block-title">Отзывы</div>
        <VueSlickCarousel class="reviews-slider" v-bind="settings" v-if="reviews.length !== 0">
            <div v-for="review in reviews" class="reviews-slider__slide">
                <div class="reviews-slider__name">{{ review.name }}</div>
                <div class="reviews-slider__text">{{ review.comment }}</div>
            </div>
        </VueSlickCarousel>
        <div v-else-if="reviews.length === 0">Отзывы отсутствуют</div>
        <review-form :id="id"></review-form>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'

import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: {VueSlickCarousel},
    data() {
        return {
            reviews: [],
            settings: {
                "lazyLoad": "ondemand",
                "dots": true,
                "dotsClass": "slick-dots custom-dot-class",
                "edgeFriction": 0.35,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 1,
                "slidesToScroll": 1
            }
        }
    },
    props: {
        id: String,
    },
    mounted() {
        axios.get('/api/v1/reviews/product/' + this.id)
            .then(({data}) => this.reviews = data.result)
            .catch((response) => console.log(response))
    }
}
</script>
