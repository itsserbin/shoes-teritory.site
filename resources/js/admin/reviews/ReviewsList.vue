<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getReviews">Очистить</button>
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
                                <div class="mr-1">Имя</div>
                                <a href="javascript:" class="text-dark" @click="sort('name','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('name','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th class="w-25">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Текст</div>
                                <a href="javascript:" class="text-dark" @click="sort('comment','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('comment','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">ID товара</div>
                                <a href="javascript:" class="text-dark" @click="sort('product_id','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('vendor_code','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            Название товара
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
                        </th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-if="reviews.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Отзывы еще не добавлены</div>
                            </div>
                        </td>
                    </tr>
                    <tr v-for="(review,index) in reviews" :key="review.id" style="vertical-align: middle;">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       :value="review.id"
                                       v-model="checkedItems"
                                >
                            </div>
                        </td>
                        <td>{{ review.id }}</td>
                        <td><a :href="'/admin/reviews/edit/' + review.id">{{review.name}}</a></td>
                        <td>{{ review.comment }}</td>
                        <td>
                            <a :href="'/product/' + review.products.id" target="_blank">
                            {{ review.products.id }}
                            </a>
                        </td>
                        <td>{{ review.products.h1.ru ? review.products.h1.ru : review.products.h1.ua }}</td>
                        <td>
                            {{ dateFormat(review.created_at) }}
                        </td>
                        <td>
                            <span v-if="review.status === 1">Опубликовано</span>
                            <div v-else>
                                На модерации <br>
                                <a href="javascript:" @click="publishReview(review.id,index)">Опубликовать</a>
                            </div>
                        </td>
                        <td>
                            <a v-bind:href="'/admin/reviews/edit/' + review.id">
                                <edit-icon></edit-icon>
                            </a>
                            <a href="javascript:" @click="onDelete(review.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="reviews.length !== 0">
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
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            reviews: [],
            isLoading: true,
            endpoint: '/api/reviews?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getReviews();
    },
    methods: {
        publishReview(id, index) {
            axios.post('/api/reviews/accept/' + id)
                .then(() => this.reviews[index].status = 1)
                .catch((response) => console.log(response))
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/reviews', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getMassActionsSuccessData(data);
                    this.isLoading = false;
                    this.endpoint = '/api/reviews?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getReviewsListErrorResponse(response));
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/reviews/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getReviewsListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getReviews();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getReviews() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/reviews')
                .then(({data}) => {
                    this.getReviewsListSuccessResponse(data);
                    this.endpoint = '/api/reviews?page=';
                })
                .catch((response) => this.getReviewsListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getReviews();
            } else {
                axios.get('/api/reviews/search=' + this.search)
                    .then(({data}) => {
                        this.getReviewsListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/reviews/search/' + this.search + '?page=';
                    })
                    // .catch((response) => this.getReviewsListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getReviewsListSuccessResponse(data) {
            this.isLoading = false;
            this.reviews = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getReviewsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getReviewsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/reviews/destroy/' + id)
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
                this.reviews.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
    }
}
</script>
