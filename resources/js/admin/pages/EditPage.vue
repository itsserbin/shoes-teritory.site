<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updatePage">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Статус публикации</label>
                        <select class="form-select" v-model="page.published">
                            <option :value="0">Не опубликовано</option>
                            <option :value="1">Опубликовано</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label class="form-label">ЧПУ</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.slug}"
                               type="text"
                               v-model="page.slug"
                               placeholder="Укажите ЧПУ"
                        >
                        <div v-if="errors.slug" class="invalid-feedback">Укажите ЧПУ</div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-3">
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
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Название в меню</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="page.heading.ru"
                               placeholder="Введите название в меню RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="page.heading.ua"
                               placeholder="Введите название в меню UA"
                               v-if="activeLang === 'ua'"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Введите название в меню</div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Заголовок на странице</label>
                        <input class="form-control"
                               type="text"
                               v-model="page.h1.ru"
                               placeholder="Введите название в меню RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="page.h1.ua"
                               placeholder="Введите название в меню UA"
                               v-if="activeLang === 'ua'"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="page.meta_title.ua"
                               placeholder="Введите META Title UA"
                               v-if="activeLang === 'ua'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="page.meta_title.ru"
                               placeholder="Введите META Title RU"
                               v-if="activeLang === 'ru'"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="page.meta_description.ru"
                                  placeholder="Введите META Description RU"
                                  v-if="activeLang === 'ru'"
                        ></textarea>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="page.meta_description.ua"
                                  placeholder="Введите META Description UA"
                                  v-if="activeLang === 'ua'"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Содержимое</label>
                        <editor
                            :api-key="this.$tinyapi"
                            v-model="page.content.ua"
                            :init="this.$tinySettings"
                            v-if="activeLang === 'ua'"
                        />
                        <editor
                            :api-key="this.$tinyapi"
                            v-model="page.content.ru"
                            :init="this.$tinySettings"
                            v-if="activeLang === 'ru'"
                        />
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
import Editor from '@tinymce/tinymce-vue';

export default {
    components: {
        'editor': Editor
    },
    data() {
        return {
            activeLang: 'ua',
            page: {
                slug: null,
                published: 0,
                heading: {
                    ru: null,
                    ua: null
                },
                h1: {
                    ru: null,
                    ua: null
                },
                content: {
                    ru: null,
                    ua: null
                },
                meta_title: {
                    ru: null,
                    ua: null
                },
                meta_description: {
                    ru: null,
                    ua: null
                }
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/pages/edit/' + id)
            .then(({data}) => this.page = data.result)
            .catch((response) => console.log(response))
    },
    methods: {
        updatePage() {
            this.isLoading = true;
            axios.put('/api/pages/update/' + this.page.id, this.page)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Обновлено!',
                        text: 'Данные успешно сохранены :)',
                        icon: 'success',
                    });
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    this.isLoading = false;
                    console.log(response);
                    this.$swal({
                        title: 'Произошла ошибка :(',
                        text: 'Проверьте корректность введенных данных, или же обратитесь за помощью к администратору',
                        icon: 'error',
                    });
                });
        }
    }
}
</script>
