<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="categories.length"
                            @click="createCategory"
                    >
                        Создать категорию
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getCategories">Очистить</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Поиск</button>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2" v-if="categories.length">
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
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-center">
                        <tr style="vertical-align: middle;">
                            <th>
                                <input class="form-check-input"
                                       type="checkbox"
                                       v-model="checkedAll"
                                       @change="checkAll"
                                >
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">ID</div>
                                    <a href="javascript:" class="text-dark" @click="sort('id','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('id','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                Фото
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Название</div>
                                    <a href="javascript:" class="text-dark" @click="sort('h1','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('h1','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Статус</div>
                                    <a href="javascript:" class="text-dark" @click="sort('published','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('published','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Родительская категория</div>
                                    <a href="javascript:" class="text-dark" @click="sort('published','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('published','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Сортировка</div>
                                    <a href="javascript:" class="text-dark" @click="sort('sort','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('sort','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Создано</div>
                                    <a href="javascript:" class="text-dark" @click="sort('created_at','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('created_at','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                                <hr class="m-1">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Обновлено</div>
                                    <a href="javascript:" class="text-dark" @click="sort('updated_at','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('updated_at','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-if="categories.length === 0">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Категории не созданы</div>
                                    <button
                                        @click="createCategory"
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Создать категорию
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="category in categories" :key="category.id" style="vertical-align: middle;">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           :value="category.id"
                                           v-model="checkedItems"
                                    >
                                </div>
                            </td>
                            <td>
                                <a :href="'/admin/categories/edit/' + category.id">
                                    {{ category.id }}
                                </a>
                            </td>
                            <td class="w-25">
                                <img class="w-25"
                                     :src="category.preview ? category.preview : '/storage/no_image.png'"
                                     :alt="category.title.ru" v-if="activeLang === 'ru'">
                                <img class="w-25"
                                     :src="category.preview ? category.preview : '/storage/no_image.png'"
                                     :alt="category.title.ua" v-if="activeLang === 'ua'">
                            </td>
                            <td>
                                <a :href="'/admin/categories/edit/' + category.id" v-if="activeLang === 'ru'">
                                    {{ category.title.ru }}
                                </a>
                                <a :href="'/admin/categories/edit/' + category.id" v-if="activeLang === 'ua'">
                                    {{ category.title.ua }}
                                </a>
                            </td>
                            <td>{{ publishedStatus(category.published) }}</td>
                            <td>{{ category.parent_id }}</td>
                            <td>
                                <form class="d-flex justify-content-center"
                                      @submit.prevent="updateCategorySort(category.id,category.sort)">
                                    <input class="w-25 text-center" type="text" v-model="category.sort">
                                    <button type="submit" class="btn">
                                        <save-icon></save-icon>
                                    </button>
                                </form>
                            </td>
                            <td>
                                {{ dateFormat(category.created_at) }}
                                <hr class="m-1">
                                {{ dateFormat(category.updated_at) }}
                            </td>
                            <td>
                                <a v-bind:href="'/admin/categories/edit/' + category.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(category.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="categories.length !== 0">
                        <tr>
                            <th colspan="10">
                                <select class="form-select"
                                        @change="selectedAction"
                                        v-model="checkedItemsAction"
                                >
                                    <option :value="null">Выберите действие</option>
                                    <option :value="publishedMassAction">Опубликовать</option>
                                    <option :value="notPublishedMassAction">Снять с публикации</option>
                                    <option :value="destroyMassAction">Удалить</option>
                                </select>
                            </th>
                        </tr>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeLang: 'ua',
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            search: null,
            categories: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/categories?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getCategories();
    },
    props: {
        destroyMassAction: String,
        publishedMassAction: String,
        notPublishedMassAction: String,
    },
    methods: {
        getCategories() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/categories')
                .then(({data}) => this.getCategoriesListSuccessResponse(data))
                .catch((response) => this.getCategoriesListErrorResponse(response));
        },
        updateCategorySort(category_id, sort) {
            axios.post('/api/categories/update-sort/' + category_id, {sort: sort})
                .then(() => {
                    this.$swal({
                        icon: 'success',
                        title: 'Сохранено'
                    })
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        icon: 'error',
                        title: 'Ошибка'
                    })
                })
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getCategories();
            } else {
                axios.get('/api/categories/search=' + this.search)
                    .then(({data}) => {
                        this.getCategoriesListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/categories/search/' + this.search + '?page=';
                    })
                    .catch((response) => this.getCategoriesListErrorResponse(response));
            }

        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/categories', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getCategoriesListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/categories?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getCategoriesListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.categories.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/categories/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => {
                    this.getCategories();
                    this.isLoading = false;
                    this.checkedAll = false;
                    this.checkedItems = [];
                    this.checkedItemsAction = null;
                })
                .catch((response) => this.getCategoriesListErrorResponse(response));
        },
        getCategoriesListSuccessResponse(data) {
            this.categories = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getCategoriesListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getCategoriesListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/categories/destroy/' + id)
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
        createCategory() {
            window.location.href = '/admin/categories/create';
        },
        publishedStatus(status) {
            switch (status) {
                case 0:
                    return 'Не опубликован';
                case 1:
                    return 'Опубликован';
            }
        },
    },
}
</script>
