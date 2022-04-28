<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="translations.length !== 0">
                <div class="col">
                    <button
                        @click="createTranslation"
                        class="btn btn-danger w-25">
                        Добавить
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getTranslations">Очистить</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Поиск</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-center">
                    <tr style="vertical-align: middle;">
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Уникальный идентификатор</div>
                                <a href="javascript:" class="text-dark" @click="sort('slug','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('slug','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">UA</div>
                                <a href="javascript:" class="text-dark" @click="sort('ua','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('ua','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">RU</div>
                                <a href="javascript:" class="text-dark" @click="sort('ru','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('ru','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-if="translations.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Переводы еще не созданы</div>
                                <button
                                    @click="createTranslation"
                                    class="btn btn-danger w-25 m-auto"
                                >
                                    Добавить перевод
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-for="translation in translations" :key="translation.id" style="vertical-align: middle;">
                        <td>
                            <div v-if="editItem !== translation.id">{{ translation.slug }}</div>
                            <input type="text"
                                   v-model="edit.slug"
                                   v-if="editItem === translation.id"
                                   class="form-control text-center"
                            >
                        </td>
                        <td>
                            <div v-if="editItem !== translation.id">{{ translation.ua }}</div>
                            <input type="text"
                                   v-model="edit.ua"
                                   v-if="editItem === translation.id"
                                   class="form-control text-center"
                            >
                        </td>
                        <td>
                            <div v-if="editItem !== translation.id">{{ translation.ru }}</div>
                            <input type="text"
                                   v-model="edit.ru"
                                   v-if="editItem === translation.id"
                                   class="form-control text-center"
                            >
                        </td>
                        <td>
                            <div v-if="editItem !== translation.id">
                                <a href="javascript:" @click="editTranslation(translation)">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(translation.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </div>
                            <a href="javascript:" @click="updateTranslation" v-if="editItem === translation.id">
                                <save-icon></save-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="translations.length !== 0">
                    <tr>
                        <th colspan="10">
                            <pagination
                                v-model="currentPage"
                                :records="total"
                                :per-page="perPage"
                                @paginate="fetch"
                                :options="this.$paginateOptions"
                            />
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editItem: null,
            edit: {
                slug: null,
                ru: null,
                ua: null,
            },
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            translations: [],
            isLoading: true,
            endpoint: '/api/translations?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getTranslations();
    },
    methods: {
        updateTranslation() {
            axios.put('/api/translations/update/' + this.edit.id, this.edit)
                .then(() => {
                    this.editItem = null;
                    this.$swal({
                        title: 'Обновлено!',
                        icon: 'success',
                        showCancelButton: false,
                    });
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        title: 'Ошибка',
                        icon: 'error',
                        showCancelButton: false,
                    });
                });
        },
        editTranslation(translation) {
            this.editItem = translation.id;
            this.edit = translation;
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/translations', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getTranslationsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/translations?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getTranslationsListErrorResponse(response));
        },
        getTranslations() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/translations')
                .then(({data}) => {
                    this.getTranslationsListSuccessResponse(data);
                    this.endpoint = '/api/translations?page=';
                })
                .catch((response) => this.getTranslationsListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getTranslations();
            } else {
                axios.get('/api/translations/search=' + this.search)
                    .then(({data}) => {
                        this.getTranslationsListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/translations/search=' + this.search + '?page=';
                    })
                    .catch((response) => this.getTranslationsListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getTranslationsListSuccessResponse(data) {
            this.isLoading = false;
            this.translations = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getTranslationsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getTranslationsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/translations/destroy/' + id)
                        .then(() => {
                            this.fetch(1);
                            this.$swal({
                                title: 'Удалено',
                                icon: 'success',
                                showCancelButton: false,
                            });
                        })
                        .catch((response) => {
                            console.log(response);
                            this.$swal({
                                title: 'Ошибка',
                                icon: 'error',
                                showCancelButton: false,
                            });
                        });
                }
            });
        },
        createTranslation() {
            window.location.href = '/admin/options/translations/create';
        }
    }
}
</script>
