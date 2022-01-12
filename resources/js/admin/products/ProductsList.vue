<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="products.length !== 0">
                <div class="col">
                    <button
                        @click="createProduct"
                        class="btn btn-danger w-25">
                        Додати товар
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getProducts">Очистити</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Пошук</button>
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
                                <div class="mr-1">Артикул</div>
                                <a href="javascript:" class="text-dark" @click="sort('vendor_code','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('vendor_code','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Цена</div>
                                <a href="javascript:" class="text-dark" @click="sort('price','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('price','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Скидочная цена</div>
                                <a href="javascript:" class="text-dark" @click="sort('discount_price','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('discount_price','desc')">
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
                                <div class="mr-1">Просмотров</div>
                                <a href="javascript:" class="text-dark" @click="sort('viewed','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('viewed','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                            <hr class="m-1">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Покупок</div>
                                <a href="javascript:" class="text-dark" @click="sort('total_sales','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('total_sales','desc')">
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
                    <tr v-if="products.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Товары еще не созданы</div>
                                <button
                                    @click="createProduct"
                                    class="btn btn-primary w-25 m-auto"
                                >
                                    Добавить товар
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-for="product in products" :key="product.id" style="vertical-align: middle;">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       :value="product.id"
                                       v-model="checkedItems"
                                >
                            </div>
                        </td>
                        <td>{{ product.id }}</td>
                        <td class="w-25">
                            <img
                                :src="product.preview ? '/storage/products/55/' + product.preview : '/storage/no_image.png'"
                                 :alt="product.title"></td>
                        <td><a :href="'/product/' + product.id" target="_blank">{{ product.h1 }}</a></td>
                        <td>{{ publishedStatus(product.published) }}</td>
                        <td>{{ product.vendor_code }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.discount_price }}</td>
                        <td>
                            <form class="d-flex justify-content-center"
                                  @submit.prevent="updateProductSort(product.id,product.sort)">
                                <input class="w-25 text-center" type="text" v-model="product.sort">
                                <button type="submit" class="btn">
                                    <save-icon></save-icon>
                                </button>
                            </form>
                        </td>
                        <td>
                            {{ product.viewed }}
                            <hr class="m-1">
                            {{ product.total_sales }}
                        </td>
                        <td>
                            {{ dateFormat(product.created_at) }}
                            <hr class="m-1">
                            {{ dateFormat(product.updated_at) }}
                        </td>
                        <td>
                            <a v-bind:href="'/admin/products/edit/' + product.id">
                                <edit-icon></edit-icon>
                            </a>
                            <a href="javascript:" @click="onDelete(product.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="products.length !== 0">
                    <tr>
                        <th colspan="10">
                            <select class="form-select"
                                    @change="selectedAction"
                                    v-model="checkedItemsAction"
                            >
                                <option :value="null">Виберіть дію</option>
                                <option :value="publishedMassAction">Опублікувати</option>
                                <option :value="notPublishedMassAction">Зняти з публікації</option>
                                <option :value="destroyMassAction">Видалити</option>
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
    beforeCreate() {
        this.isLoading = true;
    },
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
            products: [],
            isLoading: true,
            endpoint: '/api/products?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/products', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getProductsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/products?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getProductsListErrorResponse(response));
        },
        updateProductSort(product_id, sort) {
            axios.post('/api/products/update-sort/' + product_id, {sort: sort})
                .then(() => {
                    this.$swal({
                        icon: 'success',
                        title: 'Збережено'
                    })
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        icon: 'error',
                        title: 'Помилка'
                    })
                })
        },
        selectedAction() {
            this.isLoading = true;
            axios.post('/api/products/mass', this.checkedItems, {
                params:
                    {
                        action: this.checkedItemsAction,
                    }
            })
                .then(() => this.getMassActionsSuccessData())
                .catch((response) => this.getProductsListErrorResponse(response));
        },
        getMassActionsSuccessData() {
            this.getProducts();
            this.isLoading = false;
            this.checkedAll = false;
            this.checkedItems = [];
            this.checkedItemsAction = null;
        },
        getProducts() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/products')
                .then(({data}) => {
                    this.getProductsListSuccessResponse(data);
                    this.endpoint = '/api/products?page=';
                })
                .catch((response) => this.getProductsListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getProducts();
            } else {
                axios.get('/api/products/search=' + this.search)
                    .then(({data}) => {
                        this.getProductsListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/products/search=' + this.search + '?page=';
                    })
                    .catch((response) => this.getProductsListErrorResponse(response));
            }

        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getProductsListSuccessResponse(data) {
            this.isLoading = false;
            this.products = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getProductsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getProductsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Видалити?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/products/destroy/' + id)
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
        createProduct() {
            window.location.href = '/admin/products/create';
        },
        publishedStatus(status) {
            switch (status) {
                case 0:
                    return 'Не опубліковано';
                case 1:
                    return 'Опубліковано';
            }
        },
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.products.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
    }
}
</script>
