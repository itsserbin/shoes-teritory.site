<template>
    <section id="banners" class="banners mb-3" v-if="banners.length">
        <swiper ref="mySwiper" :options="swiperOptions">
            <swiper-slide v-for="(banner,i) in banners" :key="i">
                <a :href="banner.link.ru" v-if="banner.link && lang === 'ru' && banner.image.ru">
                    <img :src="banner.image.ru" :alt="banner.title.ru">
                </a>

                <a :href="banner.link.ua" v-if="banner.link && lang === 'ua' && banner.image.ua">
                    <img :src="banner.image.ua" :alt="banner.title.ua">
                </a>

                <img :src="banner.image.ru" :alt="banner.title.ru" v-if="!banner.link && lang === 'ru' && banner.image.ru">
                <img :src="banner.image.ua" :alt="banner.title.ua" v-if="!banner.link && lang === 'ua' && banner.image.ua">
            </swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
    </section>
</template>

<script>
import {Swiper, SwiperSlide, directive} from 'vue-awesome-swiper'

export default {
    components: {
        Swiper,
        SwiperSlide
    },
    props: {
        lang: String,
    },
    directives: {
        swiper: directive
    },
    data() {
        return {
            banners: [],
            swiperOptions: {
                loop: true,
                mousewheel: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
            }
        }
    },
    mounted() {
        axios.get('/api/v1/banners/all')
            .then(({data}) => this.banners = data.result)
            .catch((response) => console.log(response));
    },
}
</script>

<style>
.swiper-slide img {
    width: 100%;
}

.swiper-wrapper {
    margin-bottom: 2rem;
}
</style>
