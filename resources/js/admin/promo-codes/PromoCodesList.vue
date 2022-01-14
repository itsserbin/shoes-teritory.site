<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="promo_codes.length !== 0">
                <div class="col">
                    <button
                        @click="createPromoCode"
                        class="btn btn-danger w-25">
                        Добавить промо-код
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getPromoCodes">Очистить</button>
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
                                <div class="mr-1">Код</div>
                                <a href="javascript:" class="text-dark" @click="sort('code','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('code','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th class="w-25">
                            Скидка
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Время окончания</div>
                                <a href="javascript:" class="text-dark" @click="sort('end_date','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('end_date','desc')">
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
                    <tr v-if="promo_codes.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Промокоды еще не созданы</div>
                            </div>
                            <button
                                @click="createPromoCode"
                                class="btn btn-danger w-25 m-auto"
                            >
                                Добавить промо-код
                            </button>
                        </td>
                    </tr>
                    <tr v-for="(promo_code) in promo_codes" :key="promo_code.id" style="vertical-align: middle;">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       :value="promo_code.id"
                                       v-model="checkedItems"
                                >
                            </div>
                        </td>
                        <td>{{ promo_code.id }}</td>
                        <td><a :href="'/admin/promo-codes/edit/' + promo_code.id">{{ promo_code.code }}</a></td>
                        <td>{{
                                promo_code.percent_discount ? promo_code.percent_discount + '%' : promo_code.discount_in_hryvnia + 'грн.'
                            }}
                        </td>
                        <td>{{ promo_code.end_date }}</td>
                        <td>{{ publishedStatus(promo_code.published) }}</td>
                        <td>
                            {{ dateFormat(promo_code.created_at) }}
                            <hr class="m-1">
                            {{ dateFormat(promo_code.updated_at) }}

                        </td>
                        <td>
                            <a v-bind:href="'/admin/promo-codes/edit/' + promo_code.id">
                                <edit-icon></edit-icon>
                            </a>
                            <a href="javascript:" @click="onDelete(promo_code.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="promo_codes.length !== 0">
                    <tr>
                        <th colspan="10">
                            <select class="form-select"
                                    @change="selectedAction"
                                    v-model="checkedItemsAction"
                            >
                                <option :value="null">Виберите действие</option>
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
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            promo_codes: [],
            isLoading: true,
            endpoint: '/api/promo-codes?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getPromoCodes();
    },
    methods: {
        createPromoCode() {
            window.location.href = '/admin/promo-codes/create';
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/promo-codes', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getMassActionsSuccessData(data);
                    this.isLoading = false;
                    this.endpoint = '/api/promo-codes?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getReviewsListErrorResponse(response));
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/promo-codes/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getPromoCodesListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getPromoCodes();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getPromoCodes() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/promo-codes')
                .then(({data}) => {
                    this.getPromoCodesListSuccessResponse(data);
                    this.endpoint = '/api/promo-codes?page=';
                })
                .catch((response) => this.getPromoCodesListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getPromoCodes();
            } else {
                axios.get('/api/promo-codes/search=' + this.search)
                    .then(({data}) => {
                        this.getPromoCodesListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/promo-codes/search/' + this.search + '?page=';
                    })
                    .catch((response) => this.getPromoCodesListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getPromoCodesListSuccessResponse(data) {
            this.isLoading = false;
            this.promo_codes = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getPromoCodesListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getPromoCodesListErrorResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Видалити?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/promo-codes/destroy/' + id)
                        .then(() => {
                            this.fetch(1);
                            this.$swal({
                                title: 'Видалено',
                                icon: 'success',
                                showCancelButton: false,
                            });
                        })
                        .catch((response) => {
                            console.log(response);
                            this.$swal({
                                title: 'Помилка',
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
                    return 'Не опубліковано';
                case 1:
                    return 'Опубліковано';
            }
        },
    }
}
</script>
