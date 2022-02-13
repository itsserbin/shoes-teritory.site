<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updateBanner">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Название баннера</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.title}"
                               type="text"
                               v-model="banner.title"
                               placeholder="Введите название"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Введите название</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="banner.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <div v-if="banner.image !== null"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Изображение</label>
                        <img :src="banner.image" :alt="banner.title" class="w-50">
                        <div>
                            <button class="btn" @click="deletePreview">
                                <edit-icon></edit-icon>
                            </button>
                            <a class="btn" v-bind:href="banner.image" target="_blank">
                                <arrow-up-icon></arrow-up-icon>
                            </a>
                        </div>
                    </div>
                    <div v-if="banner.image === null">
                        <label class="form-label">Изображение</label>
                        <input class="form-control"
                               type="file"
                               @change="uploadBannerImage"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Ссылка</label>
                        <input class="form-control"
                               type="text"
                               v-model="banner.link"
                               placeholder="Введите ссылку (необязательно)"
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
            banner: {
                title: null,
                image: null,
                published: 0,
                link: null,
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/banners/edit/' + id)
            .then(({data}) => this.banner = data.result)
            .catch((response) => console.log(response));

    },
    methods: {
        updateBanner() {
            this.isLoading = true;
            axios.put('/api/banners/update/' + this.banner.id, this.banner)
                .then(() => this.getBannerUpdateSuccessResponse())
                .catch(({response}) => this.getBannerUpdateErrorResponse(response));
        },
        getBannerUpdateSuccessResponse() {
            this.isLoading = false;
            this.$swal({
                title: 'Обновлено!',
                text: 'Баннер успешно обновлен :)',
                icon: 'success',
            });
        },
        getBannerUpdateErrorResponse(response) {
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
