<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="createBanner">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="banner.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2">
                <li class="nav-item">
                    <a class="nav-link"
                       href="javascript:"
                       @click="activeLang = 'ua'"
                       :class="{'active':activeLang === 'ua'}"
                    >UA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="javascript:"
                       @click="activeLang = 'ru'"
                       :class="{'active':activeLang === 'ru'}"
                    >RU</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-12 col-md-10">
                    <div class="form-group mb-3">
                        <label class="form-label">Название баннера</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="banner.title.ru"
                               placeholder="Введите название RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="banner.title.ua"
                               placeholder="Введите название UA"
                               v-if="activeLang === 'ua'"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Введите название</div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Ссылка</label>
                        <input class="form-control"
                               type="text"
                               v-model="banner.link.ua"
                               placeholder="Введите ссылку (необязательно) UA"
                               v-if="activeLang === 'ua'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="banner.link.ru"
                               placeholder="Введите ссылку (необязательно) RU"
                               v-if="activeLang === 'ru'"
                        >
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div v-if="banner.image.ru && activeLang === 'ru'"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Изображение</label>
                        <img :src="banner.image.ru" :alt="banner.title.ru" class="w-50" v-if="activeLang === 'ru'">
                        <div>
                            <button class="btn" @click="deletePreview" v-if="activeLang === 'ru'">
                                <edit-icon></edit-icon>
                            </button>
                            <a class="btn" v-bind:href="banner.image.ru" target="_blank" v-if="activeLang === 'ru'">
                                <arrow-up-icon></arrow-up-icon>
                            </a>
                        </div>
                    </div>
                    <div v-if="banner.image.ua && activeLang === 'ua'"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Изображение</label>
                        <img :src="banner.image.ua" :alt="banner.title.ua" class="w-50" v-if="activeLang === 'ua'">
                        <div>
                            <button class="btn" @click="deletePreview" v-if="activeLang === 'ua'">
                                <edit-icon></edit-icon>
                            </button>
                            <a class="btn" v-bind:href="banner.image.ua" target="_blank" v-if="activeLang === 'ua'">
                                <arrow-up-icon></arrow-up-icon>
                            </a>
                        </div>
                    </div>
                    <div v-if="!banner.image.ru && activeLang === 'ru'">
                        <label class="form-label">Изображение</label>
                        <input class="form-control"
                               type="file"
                               @change="uploadBannerImage"
                        >
                    </div>
                    <div v-if="!banner.image.ua && activeLang === 'ua'">
                        <label class="form-label">Изображение</label>
                        <input class="form-control"
                               type="file"
                               @change="uploadBannerImage"
                        >
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                Сохранить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeLang: 'ua',
            banner: {
                title: {
                    ua: null,
                    ru: null,
                },
                image: {
                    ua: null,
                    ru: null,
                },
                link: {
                    ua: null,
                    ru: null,
                },
                published: 0,
            },
            errors: [],
            isLoading: false,
        }
    },
    methods: {
        createBanner() {
            this.isLoading = true;
            axios.post('/api/banners/create', this.banner)
                .then(() => this.getBannerCreateSuccessResponse())
                .catch(({response}) => this.getBannerCreateErrorResponse(response));
        },
        getBannerCreateSuccessResponse() {
            this.isLoading = false;
            this.$swal({
                title: 'Добавлено!',
                text: 'Баннер успешно создан :)',
                icon: 'success',
            });
            window.location.href = '/admin/banners';
        },
        getBannerCreateErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            console.log(response);
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность введенных данных, или же обратитесь за помощью к администратору',
                icon: 'error',
            });
        },
        uploadBannerImage(event) {
            let formData = new FormData();
            formData.append('banner', event.target.files[0]);
            axios.post('/api/images/banner-upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => this.banner.image = data.url)
                .catch((response) => console.log(response));
        },
        deletePreview() {
            this.banner.image = null;
        },
    }
}
</script>
