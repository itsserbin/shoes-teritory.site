<template>
    <section id="reviews" class="reviews">
        <div class="container">
            <div class="reviews__block-title block-title">{{ textReviews }}</div>
            <VueSlickCarousel class="reviews-slider" v-bind="settings" v-if="reviews.length">
                <div v-for="review in reviews" class="reviews-slider__slide">
                    <div class="reviews-slider__name">{{ review.name }}</div>
                    <div class="reviews-slider__text">{{ review.comment }}</div>
                </div>
            </VueSlickCarousel>
            <h3 v-else-if="reviews.length === 0">{{ textNoReviews }}</h3>
        </div>
    </section>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'

import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: {VueSlickCarousel},
    props:{
        textReviews: String,
        textNoReviews: String
    },
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
                "slidesToShow": 3,
                "slidesToScroll": 2,
                "responsive": [
                    {
                        "breakpoint": 768,
                        "settings": {
                            "slidesToShow": 2,
                            "slidesToScroll": 2,
                        }
                    },
                    {
                        "breakpoint": 480,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1
                        }
                    }
                ]
            }
        }
    },
    mounted() {
        axios.get('/api/v1/reviews/list')
            .then(({data}) => this.reviews = data.result)
            .catch((response) => console.log(response));

    }
}
</script>
