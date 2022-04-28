<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="banners.length"
                            @click="createBanner"
                    >
                        Создать баннер
                    </button>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2" v-if="banners.length">
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
                            <th>Фото</th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Название</div>
                                    <a href="javascript:" class="text-dark" @click="sort('title','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('title','desc')">
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
                            <th>Ссылка</th>
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
                        <tr v-if="banners.length === 0">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Баннера не созданы</div>
                                    <button
                                        @click="createBanner"
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Добавить баннер
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="banner in banners" :key="banner.id" style="vertical-align: middle;">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           :value="banner.id"
                                           v-model="checkedItems"
                                    >
                                </div>
                            </td>
                            <td>{{ banner.id }}</td>
                            <td class="w-25">
                                <img class="w-25"
                                     :src="banner.image.ru ? banner.image.ru : '/storage/no_image.png'"
                                     :alt="banner.title.ru" v-if="activeLang === 'ru'">

                                <img class="w-25"
                                     :src="banner.image.ua ? banner.image.ua : '/storage/no_image.png'"
                                     :alt="banner.title.ua" v-if="activeLang === 'ua'">
                            </td>
                            <td>
                                <a :href="'/admin/banners/edit/' + banner.id" v-if="activeLang === 'ru'">
                                    {{ banner.title.ru }}
                                </a>
                                <a :href="'/admin/banners/edit/' + banner.id" v-if="activeLang === 'ua'">
                                    {{ banner.title.ua }}
                                </a>
                            </td>
                            <td>{{ publishedStatus(banner.published) }}</td>
                            <td>
                                <div v-if="activeLang === 'ru'">{{ banner.link.ru ? banner.link.ru : 'Не указано' }}</div>
                                <div v-if="activeLang === 'ua'">{{ banner.link.ua ? banner.link.ua : 'Не указано' }}</div>
                            </td>
                            <td>
                                <form class="d-flex justify-content-center"
                                      @submit.prevent="updateBannerSort(banner.id,banner.sort)">
                                    <input class="w-25 text-center" type="text" v-model="banner.sort">
                                    <button type="submit" class="btn">
                                        <save-icon></save-icon>
                                    </button>
                                </form>
                            </td>
                            <td>
                                {{ dateFormat(banner.created_at) }}
                                <hr class="m-1">
                                {{ dateFormat(banner.updated_at) }}
                            </td>
                            <td>
                                <a v-bind:href="'/admin/banners/edit/' + banner.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(banner.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="banners.length !== 0">
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
            banners: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/banners?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getBanners();
    },
    props: {
        destroyMassAction: String,
        publishedMassAction: String,
        notPublishedMassAction: String,
    },
    methods: {
        getBanners() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/banners')
                .then(({data}) => this.getBannersListSuccessResponse(data))
                .catch((response) => this.getBannersListErrorResponse(response));
        },
        updateBannerSort(id, sort) {
            axios.post('/api/banners/update-sort/' + id, {sort: sort})
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
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/banners', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getBannersListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/banners?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getBannersListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.banners.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/banners/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => {
                    this.getBanners();
                    this.isLoading = false;
                    this.checkedAll = false;
                    this.checkedItems = [];
                    this.checkedItemsAction = null;
                })
                .catch((response) => this.getCategoriesListErrorResponse(response));
        },
        getBannersListSuccessResponse(data) {
            this.banners = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getBannersListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getBannersListErrorResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/banners/destroy/' + id)
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
        createBanner() {
            window.location.href = '/admin/banners/create';
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
