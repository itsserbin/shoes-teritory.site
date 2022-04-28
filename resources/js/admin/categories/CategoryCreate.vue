<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="createCategory">
            <div class="row mb-3">
                <div class="col-12 col-md-8">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">ЧПУ</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.slug}"
                                       type="text"
                                       v-model="category.slug"
                                       placeholder="Укажите ЧПУ"
                                >
                                <div v-if="errors.slug" class="invalid-feedback">Укажите ЧПУ</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Статус публикации</label>
                            <select class="form-select" v-model="category.published">
                                <option :value="0">Не опубликовано</option>
                                <option :value="1">Опубликовано</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Родительская категория</label>
                            <select class="form-select" v-model="category.parent_id">
                                <option :value="null">Выберите родительскую категорию</option>
                                <option v-for="item in categories" :value="item.id">{{ item.title.ru }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div v-if="category.preview !== null"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Превью категории</label>
                        <img :src="category.preview" :alt="category.title" class="w-50">
                        <div>
                            <button class="btn" @click="deletePreview">
                                <edit-icon></edit-icon>
                            </button>
                            <a class="btn" v-bind:href="category.preview" target="_blank">
                                <arrow-up-icon></arrow-up-icon>
                            </a>
                        </div>
                    </div>
                    <div v-if="category.preview === null">
                        <label class="form-label">Превью категории</label>
                        <input class="form-control"
                               type="file"
                               @change="uploadPreview"
                        >
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
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Название категории</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="category.title.ru"
                               placeholder="Введите название категории RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="category.title.ua"
                               placeholder="Введите название категории UA"
                               v-if="activeLang === 'ua'"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Введите название категории</div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="category.meta_title.ua"
                               placeholder="Введите META Title UA"
                               v-if="activeLang === 'ua'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="category.meta_title.ru"
                               placeholder="Введите META Title RU"
                               v-if="activeLang === 'ru'"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_description.ru"
                                  placeholder="Введите META Description RU"
                                  v-if="activeLang === 'ru'"
                        ></textarea>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_description.ua"
                                  placeholder="Введите META Description UA"
                                  v-if="activeLang === 'ua'"
                        ></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Keywords</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_keyword.ua"
                                  placeholder="Введите META Keywords UA"
                                  v-if="activeLang === 'ua'"
                        ></textarea>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_keyword.ru"
                                  placeholder="Введите META Keywords RU"
                                  v-if="activeLang === 'ru'"
                        ></textarea>
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
            category: {
                slug: null,
                parent_id: null,
                preview: null,
                published: 0,
                title: {
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
                },
                meta_keyword: {
                    ru: null,
                    ua: null
                }
            },
            categories: [],
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        axios.get('/api/categories/all')
            .then(({data}) => this.categories = data.result)
            .catch((response) => console.log(response));
    },
    methods: {
        createCategory() {
            this.isLoading = true;
            axios.post('/api/categories/create', this.category)
                .then(() => this.getCategoryCreateSuccessResponse())
                .catch(({response}) => this.getCategoryCreateErrorResponse(response));
        },
        getCategoryCreateSuccessResponse() {
            this.isLoading = false;
            this.$swal({
                title: 'Добавлено!',
                text: 'Категория была успешно создана :)',
                icon: 'success',
            });
            window.location.href = '/admin/categories';
        },
        getCategoryCreateErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            console.log(response);
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность введенных данных, или же обратитесь за помощью к администратору',
                icon: 'error',
            });
        },
        uploadPreview(event) {
            let formData = new FormData();
            formData.append('preview', event.target.files[0]);
            formData.append('type', 'categories');
            axios.post('/api/images/preview-upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => this.category.preview = data.url)
                .catch((response) => console.log(response));
        },
        deletePreview() {
            this.category.preview = null;
        },
    }
}
</script>
