<template>
    <div>
        <div class="container mt-2">
            <div class="row align-items-center">
                <div class="col-4 header__logo logo">
                    <a :href="indexRoute">
<!--                        <img :src="logoApp" :alt="appName" v-if="logoApp">-->
                        <span class="h1">{{appName}}</span>
                    </a>
                </div>
                <div class="col-4 d-flex justify-content-center">
                    <cart-icon-component :cart-route="cartRoute"></cart-icon-component>
                </div>
<!--                <div class="col-2 d-flex justify-content-end">-->
<!--                    <div class="header__language" @click="setLangActiveClass">-->
<!--                        <div class="language-chooser">-->
<!--                            <div class="language-chooser__current">-->
<!--                                <div class="language-chooser__current-label">{{ lang === 'ru' ? 'RU' : 'UA' }}</div>-->
<!--                            </div>-->
<!--                            <div class="language-chooser__drop" :class="{'active': langActiveClass}">-->
<!--                                <div class="language-chooser__drop-item lang-switcher">-->
<!--                                    <a class="language-chooser__link" :href="setlocateUa">UA</a>-->
<!--                                </div>-->
<!--                                <div class="language-chooser__drop-item lang-switcher">-->
<!--                                    <a class="language-chooser__link" :href="setlocateRu">RU</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="col-2 d-flex justify-content-end">
                    <div class="header-burger p-0"
                         @click="showBurgerMenu"
                         :class="{'active': showBurger}"
                    >
                        <span></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="header__menu">

           <div class="container">
               <div class="row">
                   <nav class="main-menu">
                       <ul class="main-menu__list">
                           <VueSlickCarousel v-bind="settings" v-if="categoriesList.length">
                               <li class="main-menu__item main-menu__item_sub"
                                   v-for="category in categoriesList"
                                   :key="category.id"
                               >
                                   <a :href="categoryRoute + '/' + category.slug" class="main-menu__item-link ">
                                    <span class="main-menu__item-label">
                                        {{lang === 'ua' ? category.title.ua : (lang === 'ru' ? category.title.ru : null)}}
                                    </span>
                                   </a>
                               </li>
                           </VueSlickCarousel>
                       </ul>
                   </nav>
               </div>
           </div>
        </div>

        <div class="burger-menu active" v-if="showBurger">
           <div class="menus justify-content-center align-items-center">
               <nav class="menu">
                   <ul class="menu__list">
                       <li  v-for="category in categoriesList" :key="category.id">
                           <a :href="categoryRoute + '/' + category.slug" class="menu__link text-decoration-none">
                               {{lang === 'ua' ? category.title.ua : (lang === 'ru' ? category.title.ru : null)}}
                           </a>
                       </li>
                   </ul>
               </nav>
               <nav class="menu">
                   <ul class="menu__list">
                       <li>
                           <a :href="indexRoute" class="menu__link text-decoration-none">
                               {{ lang === 'ru' ? 'Главная' : 'Головна' }}
                           </a>
                       </li>
                       <li v-for="page in pagesList" :key="page.id">
                           <a :href="'/pages/' + page.slug" class="menu__link text-decoration-none">
                               {{ lang === 'ru' ? page.heading.ru : page.heading.ua }}
                           </a>
                       </li>
                   </ul>
               </nav>
           </div>
            <div class="burger-menu__contacts">
                <div class="row">
                    <address class="address text-center">

                        <a v-if="appPhone"
                           :href="'tel:' + appPhone"
                           class="phonecall text-decoration-none"
                        >
                            {{ appPhone }}
                        </a>

                        <a v-if="appEmail"
                           :href="'mailto:' + appEmail"
                           class="email text-decoration-none">
                            {{ appEmail }}
                        </a>

                    </address>
                    <div class="social-buttons">
                        <a v-if="appFacebook" :href="appFacebook" target="_blank">
                            <facebook-icon></facebook-icon>
                        </a>

                        <a v-if="appInstagram" :href="appInstagram" target="_blank">
                            <instagram-icon></instagram-icon>
                        </a>

                    </div>
                </div>
                <div class="row">

                    <div v-if="appSchedule" class="burger-menu__schedule schedule text-center">
                        <div v-html="appSchedule"></div>
                    </div>

                    <div class="burger-menu__messengers messengers">
                        <a v-if="appTelegram" :href="appTelegram" target="_blank">
                            <telegram-icon></telegram-icon>
                        </a>

                        <a v-if="appViber" :href="appViber" target="_blank">
                            <viber-icon></viber-icon>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: {VueSlickCarousel},
    data() {
        return {
            showBurger: false,
            pagesList: [],
            categoriesList: [],
            langActiveClass: false,
            settings: {
                "dots": false,
                "arrows": false,
                "edgeFriction": 0.35,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 5,
                "slidesToScroll": 3,
                "responsive": [
                    {
                        "breakpoint": 1024,
                        "settings": {
                            "slidesToShow": 5,
                            "slidesToScroll": 3,
                        }
                    },
                    {
                        "breakpoint": 768,
                        "settings": {
                            "slidesToShow": 4,
                            "slidesToScroll": 2,
                        }
                    },
                    {
                        "breakpoint": 480,
                        "settings": {
                            "slidesToShow": 2,
                            "slidesToScroll": 1
                        }
                    }
                ]
            }
        }
    },
    props: {
        indexRoute: String,
        exchangePolicyRoute: String,
        privacyPolicyRoute: String,
        logoApp: String,
        appName: String,
        appPhone: String,
        appEmail: String,
        appFacebook: String,
        appInstagram: String,
        appSchedule: String,
        appTelegram: String,
        appViber: String,
        pages: String,
        lang: String,
        setlocateRu: String,
        setlocateUa: String,
        cartRoute: String,
        categories: String,
        categoryRoute: String,
    },
    created() {
        window.addEventListener('scroll', this.handleSCroll);
        this.pagesList = JSON.parse(this.pages);
        this.categoriesList = JSON.parse(this.categories);
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleSCroll);
    },
    methods: {
        showBurgerMenu() {
            this.showBurger = !this.showBurger;
        },
        handleSCroll(event) {
            let header = document.querySelector(".header");
            if (window.scrollY > 50 && !header.className.includes('shadow')) {
                header.classList.add('shadow');
            } else if (window.scrollY < 50) {
                header.classList.remove('shadow');
            }
        },
        setLangActiveClass() {
            this.langActiveClass = !this.langActiveClass;
        }
    }
}
</script>
