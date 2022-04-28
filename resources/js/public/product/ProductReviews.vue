<template>
    <div id="reviews" class="reviews">
        <div class="reviews__title block-title">{{ textProductReviews }}</div>
        <VueSlickCarousel class="reviews-slider" v-bind="settings" v-if="reviews.length !== 0">
            <div v-for="review in reviews" class="reviews-slider__slide">
                <div class="reviews-slider__name">{{ review.name }}</div>
                <div class="reviews-slider__text">{{ review.comment }}</div>
            </div>
        </VueSlickCarousel>
        <div v-else-if="reviews.length === 0">{{ textNoReviews }}</div>
        <review-form
            :id="id"
            :text-give-review="textGiveReview"
            :text-enter-name="textEnterName"
            :text-enter-review="textEnterReview"
        ></review-form>
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
        textProductReviews: String,
        textNoReviews: String,
        textGiveReview: String,
        textEnterName: String,
        textEnterReview: String,
    },
    mounted() {
        axios.get('/api/v1/reviews/product/' + this.id)
            .then(({data}) => this.reviews = data.result)
            .catch((response) => console.log(response))
    }
}
</script>
