<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="advantages.length"
                            @click="createAdvantage"
                    >
                        Добавить преимущество
                    </button>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2" v-if="advantages.length">
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
                            <th>ID</th>
                            <th>Изображение</th>
                            <th>Текст</th>
                            <th>Статус публикации</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-if="advantages.length === 0">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Преимущества не созданы</div>
                                    <button
                                        @click="createAdvantage"
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Добавить преимущество
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="advantage in advantages" :key="advantage.id" style="vertical-align: middle;">
                            <td>{{ advantage.id }}</td>
                            <td>
                                <div v-html="advantage.icon"></div>
                            </td>
                            <td>
                                <div v-if="activeLang === 'ru'">{{ advantage.text.ru }}</div>
                                <div v-if="activeLang === 'ua'">{{ advantage.text.ua }}</div>
                            </td>
                            <td>{{ publishedStatus(advantage.published) }}</td>
                            <td>
                                <a v-bind:href="'/admin/options/advantages/edit/' + advantage.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(advantage.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="advantages.length !== 0">
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
            advantages: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/advantages?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getAdvantages();
    },
    methods: {
        getAdvantages() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/advantages')
                .then(({data}) => this.getAdvantagesListSuccessResponse(data))
                .catch((response) => this.getAdvantagesListErrorResponse(response));
        },
        getAdvantagesListSuccessResponse(data) {
            this.advantages = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getAdvantagesListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getAdvantagesListErrorResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/advantages/destroy/' + id)
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
        createAdvantage() {
            window.location.href = '/admin/options/advantages/create';
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
