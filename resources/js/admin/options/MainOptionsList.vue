<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading">
            <div class="mb-3">
                <label for="brand"
                       class="form-label"
                >Название бренда</label>
                <input type="text"
                       class="form-control"
                       id="brand"
                       v-model="options.brand"
                       placeholder="Введите название бренда"
                >
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="meta_title_ua"
                           class="form-label"
                    >META Title для главной страницы UA</label>
                    <input type="text"
                           class="form-control"
                           id="meta_title_ua"
                           v-model="options.meta_title_ua"
                           placeholder="Введите META Title UA"
                    >
                </div>
                <div class="col-12 col-md-6">
                    <label for="meta_title_ru"
                           class="form-label"
                    >META Title для главной страницы RU</label>
                    <input type="text"
                           class="form-control"
                           id="meta_title_ru"
                           v-model="options.meta_title_ru"
                           placeholder="Введите META Title RU"
                    >
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="meta_description_ua"
                           class="form-label"
                    >META Description для главной страницы UA</label>
                    <textarea type="text"
                              class="form-control"
                              id="meta_description_ua"
                              rows="3"
                              v-model="options.meta_description_ua"
                              placeholder="Введите META Description UA"
                    ></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label for="meta_description_ru"
                           class="form-label"
                    >META Description для главной страницы RU</label>
                    <textarea type="text"
                              class="form-control"
                              id="meta_description_ru"
                              rows="3"
                              v-model="options.meta_description_ru"
                              placeholder="Введите META Description RU"
                    ></textarea>
                </div>
            </div>

            <hr class="my-3">

            <div class="mb-3">
                <label class="form-label">График работы</label>
                <textarea type="text"
                          class="form-control"
                          v-model="options.schedule"
                          placeholder="Введите график работы"
                          rows="4"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="phone"
                       class="form-label"
                >Телефон</label>
                <input type="phone"
                       class="form-control"
                       id="phone"
                       v-model="options.phone"
                       placeholder="Введите телефон компании"
                >
            </div>

            <div class="mb-3">
                <label for="email"
                       class="form-label"
                >Email</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       v-model="options.email"
                       placeholder="Введите e-mail компании"
                >
            </div>

            <div class="mb-3">
                <label for="facebook"
                       class="form-label"
                >Facebook</label>
                <input type="url"
                       class="form-control"
                       id="facebook"
                       v-model="options.facebook"
                       placeholder="Введите ссылку на facebook компании"
                >
            </div>

            <div class="mb-3">
                <label for="instagram"
                       class="form-label"
                >Instagram</label>
                <input type="url"
                       class="form-control"
                       id="instagram"
                       v-model="options.instagram"
                       placeholder="Введите ссылку на instagram компании"
                >
            </div>

            <div class="mb-3">
                <label
                    for="telegram"
                    class="form-label"
                >Telegram</label>
                <input type="url"
                       class="form-control"
                       id="telegram"
                       v-model="options.telegram"
                       placeholder="Введите ссылку на telegram компании"
                >
            </div>

            <div class="mb-3">
                <label for="viber"
                       class="form-label"
                >Viber</label>
                <input type="url"
                       class="form-control"
                       id="viber"
                       v-model="options.viber"
                       placeholder="Введите ссылку на viber компании"
                >
            </div>

            <div class="mb-3">
                <label for="whatsapp"
                       class="form-label"
                >Whatsapp</label>
                <input type="url"
                       class="form-control"
                       id="whatsapp"
                       v-model="options.whatsapp"
                       placeholder="Введите ссылку на whatsapp компании"
                >
            </div>

            <div class="mb-3">
                <label for="fb_messenger"
                       class="form-label"
                >Facebook messenger</label>
                <input type="url"
                       class="form-control"
                       id="fb_messenger"
                       v-model="options.fb_messenger"
                       placeholder="Введите ссылку на facebook messenger компании"
                >
            </div>

            <hr class="my-3">

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Текст "Доставка и оплата" на странице товара UA</label>
                        <editor :api-key="this.$tinyapi" v-model="options.text_delivery_and_payment_ua"
                                :init="this.$tinySettings"/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Текст "Доставка и оплата" на странице товара RU</label>
                        <editor :api-key="this.$tinyapi" v-model="options.text_delivery_and_payment_ru"
                                :init="this.$tinySettings"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Текст "Обмен и возврат" на странице товара UA</label>
                        <editor :api-key="this.$tinyapi" v-model="options.text_return_and_exchange_ua"
                                :init="this.$tinySettings"/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Текст "Обмен и возврат" на странице товара RU</label>
                        <editor :api-key="this.$tinyapi" v-model="options.text_return_and_exchange_ru"
                                :init="this.$tinySettings"/>
                    </div>
                </div>
            </div>


            <button class="btn btn-danger" type="button" @click.prevent="updateOptions">Сохранить</button>
        </form>
    </div>

</template>

<script>
import Editor from '@tinymce/tinymce-vue';

export default {
    components: {
        'editor': Editor
    },
    data() {
        return {
            isLoading: true,
            options: {
                brand: null,
                schedule: null,
                phone: null,
                email: null,
                facebook: null,
                instagram: null,
                telegram: null,
                viber: null,
                whatsapp: null,
                fb_messenger: null,
                meta_title_ua: null,
                meta_title_ru: null,
                meta_description_ua: null,
                meta_description_ru: null,
                text_delivery_and_payment_ua: null,
                text_return_and_exchange_ua: null,
                text_delivery_and_payment_ru: null,
                text_return_and_exchange_ru: null,
            }
        }
    },
    mounted() {
        axios.get('/api/options/main')
            .then(({data}) => {
                this.options.schedule = data.result.schedule ? data.result.schedule.value : null;
                this.options.phone = data.result.phone ? data.result.phone.value : null;
                this.options.email = data.result.email ? data.result.email.value : null;
                this.options.facebook = data.result.facebook ? data.result.facebook.value : null;
                this.options.instagram = data.result.instagram ? data.result.instagram.value : null;
                this.options.viber = data.result.viber ? data.result.viber.value : null;
                this.options.whatsapp = data.result.whatsapp ? data.result.whatsapp.value : null;
                this.options.fb_messenger = data.result.fb_messenger ? data.result.fb_messenger.value : null;
                this.options.brand = data.result.brand ? data.result.brand.value : null;
                this.options.meta_title_ua = data.result.meta_title_ua ? data.result.meta_title_ua.value : null;
                this.options.meta_description_ua = data.result.meta_description_ua ? data.result.meta_description_ua.value : null;
                this.options.meta_title_ru = data.result.meta_title_ru ? data.result.meta_title_ru.value : null;
                this.options.meta_description_ru = data.result.meta_description_ru ? data.result.meta_description_ru.value : null;
                this.options.text_delivery_and_payment_ua = data.result.text_delivery_and_payment_ua ? data.result.text_delivery_and_payment_ua.value : null;
                this.options.text_return_and_exchange_ua = data.result.text_return_and_exchange_ua ? data.result.text_return_and_exchange_ua.value : null;
                this.options.text_delivery_and_payment_ru = data.result.text_delivery_and_payment_ru ? data.result.text_delivery_and_payment_ru.value : null;
                this.options.text_return_and_exchange_ru = data.result.text_return_and_exchange_ru ? data.result.text_return_and_exchange_ru.value : null;
                this.isLoading = false;
            })
            .catch((response) => console.log(response))
    },
    methods: {
        updateOptions() {
            this.isLoading = true;

            axios.put('/api/options/main/update', this.options)
                .then(() => {
                    this.$swal({
                        'icon': 'success',
                        'title': 'Обновлено!',
                        'text': 'Настройки успешно сохранены :)',
                    });
                    this.isLoading = false;
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        'icon': 'error',
                        'title': 'Ошибка',
                        'text': 'Обратитесь к администратору',
                    });
                    this.isLoading = false;
                })
        }
    }
}
</script>
