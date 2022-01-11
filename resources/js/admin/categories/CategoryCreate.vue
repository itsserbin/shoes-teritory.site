<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="createCategory">
            <div class="row mb-3">
                <div class="col-12 col-md-8">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Назва категорії</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.title}"
                                       type="text"
                                       v-model="category.title"
                                       placeholder="Введіть назву"
                                >
                                <div v-if="errors.title" class="invalid-feedback">Вкажіть назву</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">ЧПУ</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.slug}"
                                       type="text"
                                       v-model="category.slug"
                                       placeholder="Введіть ЧПУ"
                                >
                                <div v-if="errors.slug" class="invalid-feedback">Вкажіть ЧПУ</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Статус публікації</label>
                            <select class="form-select" v-model="category.published">
                                <option :value="0">Не опубліковано</option>
                                <option :value="1">Опубліковано</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Батьківська категорія</label>
                            <select class="form-select" v-model="category.parent_id">
                                <option :value="null">Виберіть батьківськуу категорію</option>
                                <option v-for="item in categories" :value="item.id">{{ item.title }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div v-if="category.preview !== null"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Головне зображення</label>
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
                        <label class="form-label">Головне зображення</label>
                        <input class="form-control"
                               type="file"
                               @change="uploadPreview"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="category.meta_title"
                               placeholder="Введіть META Title"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_description"
                                  placeholder="Введіть META Description"
                        ></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">META Keywords</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="category.meta_description"
                                  placeholder="Введіть META Description"
                        ></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                Зберегти
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: {
                title: null,
                slug: null,
                parent_id: null,
                preview: null,
                published: 0,
                meta_title: null,
                meta_description: null,
                meta_keyword: null,
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
