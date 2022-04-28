<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="pages.length !== 0">
                <div class="col">
                    <button
                        @click="createPage"
                        class="btn btn-danger w-25">
                        Добавить страницу
                    </button>
                </div>
            </div>

            <ul class="nav nav-tabs justify-content-center my-2" v-if="pages.length">
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
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Название в меню</div>
                                <a href="javascript:" class="text-dark" @click="sort('heading','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('heading','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Заголовок</div>
                                <a href="javascript:" class="text-dark" @click="sort('h1','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('h1','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>Статус</th>
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
                    <tr v-if="pages.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Страницы еще не созданы</div>
                            </div>
                            <button
                                @click="createPage"
                                class="btn btn-danger w-25 m-auto"
                            >
                                Добавить страницу
                            </button>
                        </td>
                    </tr>
                    <tr v-for="page in pages" :key="page.id" style="vertical-align: middle;">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       :value="page.id"
                                       v-model="checkedItems"
                                >
                            </div>
                        </td>
                        <td>{{ page.id }}</td>
                        <td>
                            <a :href="'/admin/pages/edit/' + page.id" v-if="activeLang === 'ru'">
                                {{ page.heading.ru }}
                            </a>
                            <a :href="'/admin/pages/edit/' + page.id" v-if="activeLang === 'ua'">
                                {{ page.heading.ua }}
                            </a>
                        </td>
                        <td>
                            <a :href="'/pages/' + page.slug" target="_blank" v-if="activeLang === 'ru'">
                                {{ page.h1.ru }}
                            </a>
                            <a :href="'/pages/' + page.slug" target="_blank" v-if="activeLang === 'ua'">
                                {{ page.h1.ua }}
                            </a>
                        </td>
                        <td>{{ publishedStatus(page.published) }}</td>
                        <td>
                            {{ dateFormat(page.created_at) }}
                            <hr class="m-1">
                            {{ dateFormat(page.updated_at) }}

                        </td>
                        <td>
                            <a href="javascript:" @click="onDelete(page.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="pages.length !== 0">
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
</template>

<script>
export default {
    props: {
        destroyMassAction: String,
        publishedMassAction: String,
        notPublishedMassAction: String,
    },
    data() {
        return {
            activeLang: 'ua',
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            pages: [],
            isLoading: true,
            endpoint: '/api/pages?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getPages();
    },
    methods: {
        createPage() {
            window.location.href = '/admin/pages/create';
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/pages', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getMassActionsSuccessData(data);
                    this.isLoading = false;
                    this.endpoint = '/api/pages?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getPagesListErrorResponse(response));
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/pages/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getPagesListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getPages();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getPages() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/pages')
                .then(({data}) => {
                    this.getPagesListSuccessResponse(data);
                    this.endpoint = '/api/pages?page=';
                })
                .catch((response) => this.getPagesListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getPagesListSuccessResponse(data) {
            this.isLoading = false;
            this.pages = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getPagesListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getPagesListErrorResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/pages/destroy/' + id)
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
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.promo_codes.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
        publishedStatus(status) {
            switch (status) {
                case 0:
                    return 'Не опубликовано';
                case 1:
                    return 'Опубликовано';
            }
        },
    }
}
</script>
