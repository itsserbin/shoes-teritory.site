<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="createTranslation">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Уникальный идентификатор</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.slug}"
                                       type="text"
                                       v-model="translation.slug"
                                       placeholder="Введите slug"
                                >
                                <input-invalid-feedback v-if="errors.slug" :errors="errors.slug"></input-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">UA</label>
                                <input class="form-control"
                                       type="text"
                                       v-model="translation.ua"
                                       placeholder="Введите перевод UA"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">RU</label>
                                <input class="form-control"
                                       type="text"
                                       v-model="translation.ru"
                                       placeholder="Введите перевод RU"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger my-3">
                Сохранить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            translation: {
                slug: null,
                ru: null,
                ua: null,
            },
            errors: [],
            isLoading: false,
        }
    },
    methods: {
        createTranslation() {
            this.errors = [];
            this.isLoading = true;
            axios.post('/api/translations/create', this.translation)
                .then(() => {
                    this.errors = [];
                    this.isLoading = false;
                    this.$swal({
                        title: 'Добавлен!',
                        text: 'Перевод успешно добавлен',
                        icon: 'success',
                    });

                    window.location.href = '/admin/options/translations'
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    this.isLoading = false;
                    this.$swal({
                        title: 'Произошла ошибка :(',
                        text: 'Проверьте корректность заполненных данных, или же обратитесь к администратору',
                        icon: 'error',
                    });
                });
        }
    }
}
</script>
