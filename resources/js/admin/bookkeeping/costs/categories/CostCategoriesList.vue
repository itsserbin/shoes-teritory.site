<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <h2>Категории расходов</h2>
                </div>

                <div class="col-12 col-md-6 text-end">
                    <button class="btn btn-danger"
                            @click="createCostCategory"
                    >
                        Добавить категорию
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-center">
                        <tr style="vertical-align: middle;">
                            <th>ID</th>
                            <th>Название</th>
                            <th>Slug</th>
                            <th>
                                Создано
                                <hr class="my-1">
                                Обновлено
                            </th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-if="costsCategories.length === 0">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Расходы не добавлены</div>
                                    <button
                                        @click="createCostCategory"
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Добавить категорию
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="costsCategory in costsCategories"
                            :key="costsCategory.id"
                            style="vertical-align: middle;"
                        >
                            <td>{{ costsCategory.id }}</td>
                            <td>
                                <a :href="'/admin/bookkeeping/costs/categories/edit/' + costsCategory.id">
                                    {{ costsCategory.title }}
                                </a>
                            </td>
                            <td>{{ costsCategory.slug }}</td>
                            <td>
                                {{ dateFormat(costsCategory.created_at) }}
                                <hr class="my-0">
                                {{ dateFormat(costsCategory.updated_at) }}
                            </td>
                            <td>
                                <a :href="'/admin/bookkeeping/costs/categories/edit/' + costsCategory.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(costsCategory.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="costsCategories.length !== 0">
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
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            search: null,
            costsCategories: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/bookkeeping/costs/categories?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getCostsCategories();
    },
    props: {
        destroyMassAction: String,
    },
    methods: {
        getCostsCategories() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/bookkeeping/costs/categories')
                .then(({data}) => this.getCostsCategoriesListSuccessResponse(data))
                .catch((response) => this.getCostsCategoriesListErrorResponse(response));
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/bookkeeping/costs/categories', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getCostsCategoriesListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/bookkeeping/costs/categories?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getCostsCategoriesListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getCostsCategoriesListSuccessResponse(data) {
            this.costsCategories = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getCostsCategoriesListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getCostsCategoriesListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/bookkeeping/costs/categories/destroy/' + id)
                        .then(() => {
                            this.fetch(1);
                            this.$swal({
                                title: 'Удалено!',
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
        createCostCategory() {
            window.location.href = '/admin/bookkeeping/costs/categories/create';
        }
    },
}
</script>
