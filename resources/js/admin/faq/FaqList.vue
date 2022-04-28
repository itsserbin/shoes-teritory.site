<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="faqs.length"
                            @click="createFaq"
                    >
                        Добавить вопрос-ответ
                    </button>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2" v-if="faqs.length">
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
                            <th>Вопрос</th>
                            <th>Ответ</th>
                            <th>Статус публикации</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-if="!faqs.length">
                            <td colspan="10">
                                <div class="row justify-content-center flex-column align-content-center">
                                    <div class="h2">Вопрос-ответ не добавлены</div>
                                    <button
                                        @click="createFaq"
                                        class="btn btn-danger w-25 m-auto"
                                    >
                                        Добавить вопрос-ответ
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="faq in faqs" :key="faq.id" style="vertical-align: middle;">
                            <td>{{ faq.id }}</td>
                            <td>
                                <div v-if="activeLang === 'ru'">{{ faq.question.ru }}</div>
                                <div v-if="activeLang === 'ua'">{{ faq.question.ua }}</div>
                            </td>
                            <td>
                                <div v-if="activeLang === 'ru'">{{ faq.answer.ru ? faq.answer.ru.substr(0, 60) + '...' : '-'}}</div>
                                <div v-if="activeLang === 'ua'">{{ faq.answer.ua ? faq.answer.ua.substr(0, 60) + '...' : '-'}}</div>
                            </td>
                            <td>{{ publishedStatus(faq.published) }}</td>
                            <td>
                                <a v-bind:href="'/admin/options/faq/edit/' + faq.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(faq.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="faqs.length !== 0">
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
            faqs: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/faq?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getFaqs();
    },
    methods: {
        getFaqs() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/faq')
                .then(({data}) => this.getFaqsListSuccessResponse(data))
                .catch((response) => this.getFaqsListErrorResponse(response));
        },
        getFaqsListSuccessResponse(data) {
            this.faqs = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getFaqsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getFaqsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/faq/destroy/' + id)
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
        createFaq() {
            window.location.href = '/admin/options/faq/create';
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
