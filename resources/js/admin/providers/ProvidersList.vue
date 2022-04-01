<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="providers.length !== 0">
                <div class="col">
                    <button
                        @click="createProvider"
                        class="btn btn-danger w-25">
                        Добавить поставщика
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-center">
                    <tr style="vertical-align: middle;">
                        <th>ID</th>
                        <th>Название</th>
                        <th>Каталог</th>
                        <th>Наличие</th>
                        <th>Возвраты</th>
                        <th>Предоплата</th>
                        <th>Время отправки</th>
                        <th>Контакты</th>
                        <th>Комментарий</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-if="providers.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Поставщики не добавлены</div>
                                <button
                                    @click="createProvider"
                                    class="btn btn-danger w-25 m-auto"
                                >
                                    Добавить поставщика
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-for="provider in providers" :key="provider.id" style="vertical-align: middle;">
                        <td>
                            <a :href="'/admin/bookkeeping/providers/edit/' + provider.id">
                                {{ provider.id }}
                            </a>
                        </td>
                        <td>
                            <a :href="'/admin/bookkeeping/providers/edit/' + provider.id">
                                {{ provider.name }}
                            </a>
                        </td>
                        <td>
                            <a target="_blank"
                               :href="provider.catalog"
                               v-if="provider.catalog">
                                {{ provider.catalog.substr(0, 30) + '...' }}
                            </a>
                            <div v-else>Не указан</div>
                        </td>
                        <td>
                            <a target="_blank"
                               :href="provider.availability"
                               v-if="provider.availability">
                                {{ provider.availability.substr(0, 30) + '...' }}
                            </a>
                            <div v-else>Не указан</div>
                        </td>
                        <td>
                            <div v-if="provider.refunds === 1">
                                {{ provider.refunds_sum }} грн.
                            </div>
                            <div v-else>Нет</div>
                        </td>
                        <td>
                            <div v-if="provider.prepayment === 1">
                                {{ provider.prepayment_sum }} грн.
                            </div>
                            <div v-else>Нет</div>
                        </td>
                        <td>{{ provider.time_of_dispatch ? provider.time_of_dispatch : 'Не указано' }}</td>
                        <td>{{ provider.contacts ? provider.contacts.substr(0, 30) + '...' : 'Нет' }}</td>
                        <td>{{ provider.comment ? provider.comment.substr(0, 30) + '...' : 'Нет' }}</td>
                        <td>
                            <a href="javascript:" @click="onDelete(provider.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="providers.length !== 0">
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
            checkedItems: [],
            checkedAll: false,
            checkedItemsAction: null,
            providers: [],
            isLoading: true,
            endpoint: '/api/providers?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
            search: null,
        }
    },
    mounted() {
        this.getProviders();
    },
    methods: {
        getProviders() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/providers')
                .then(({data}) => {
                    this.getProvidersListSuccessResponse(data);
                    this.endpoint = '/api/providers?page=';
                })
                .catch((response) => this.getProvidersListErrorResponse(response));
        },
        getProvidersListSuccessResponse(data) {
            this.isLoading = false;
            this.providers = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getProvidersListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getProvidersListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/providers/destroy/' + id)
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
        createProvider() {
            window.location.href = '/admin/bookkeeping/providers/create';
        }
    }
}
</script>
