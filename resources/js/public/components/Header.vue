<template>
    <div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col header__logo logo">
                    <a :href="indexRoute">
                        <img :src="logoApp" :alt="appName">
                    </a>
                </div>
                <div class="col">
                    <cart-icon-component></cart-icon-component>
                </div>
                <div class="header-burger col-1 p-0"
                     @click="showBurgerMenu"
                     :class="{'active': showBurger}"
                >
                    <span></span>
                </div>
            </div>
        </div>

        <div class="burger-menu active" v-if="showBurger">
            <nav class="menu">
                <ul class="menu__list">
                    <li>
                        <a :href="indexRoute" class="menu__link text-decoration-none">
                            Главная
                        </a>
                    </li>
                    <li>
                        <a :href="exchangePolicyRoute" class="menu__link text-decoration-none">
                            Обмен и возврат
                        </a>
                    </li>
                    <li>
                        <a :href="privacyPolicyRoute" class="menu__link text-decoration-none">
                            Политика Конфиденциальности</a>
                    </li>

                </ul>
            </nav>
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

                        <a v-if="appFacebook" :href="appFacebook" target="_blank">
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
export default {
    data() {
        return {
            showBurger: false,
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
    },
    created() {
        window.addEventListener('scroll', this.handleSCroll);

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
        }
    }
}
</script>
