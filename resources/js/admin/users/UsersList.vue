<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="container" v-if="!isLoading">
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-danger"
                            v-if="users.length"
                            @click="createUser"
                    >
                        Создать пользователя
                    </button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="d-flex">
                        <button class="btn btn-danger" @click.prevent="getUsers">Очистить</button>
                        <input type="text" v-model="search" class="form-control mx-1">
                        <button @click.prevent="getSearchList" type="submit" class="btn btn-danger">Поиск</button>
                    </div>
                </div>
            </div>
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
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Email</div>
                                    <a href="javascript:" class="text-dark" @click="sort('email','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('email','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                            </th>
                            <th>Роль</th>
                            <th>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Добавлен</div>
                                    <a href="javascript:" class="text-dark" @click="sort('created_at','asc')">
                                        <arrow-up-icon></arrow-up-icon>
                                    </a>
                                    <a href="javascript:" class="text-dark" @click="sort('created_at','desc')">
                                        <arrow-down-icon></arrow-down-icon>
                                    </a>
                                </div>
                                <hr class="m-1">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mr-1">Обновлен</div>
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
                        <tr v-for="user in users" :key="user.id" style="vertical-align: middle;">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           :value="user.id"
                                           v-model="checkedItems"
                                    >
                                </div>
                            </td>
                            <td>{{ user.id }}</td>
                            <td>
                                <a :href="'/admin/users/edit/' + user.id">
                                    {{ user.name }}
                                </a>
                            </td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.roles.length ? user.roles[0].name : '-' }}</td>
                            <td>
                                {{ dateFormat(user.created_at) }}
                                <hr class="m-1">
                                {{ dateFormat(user.updated_at) }}
                            </td>
                            <td>
                                <a v-bind:href="'/admin/users/edit/' + user.id">
                                    <edit-icon></edit-icon>
                                </a>
                                <a href="javascript:" @click="onDelete(user.id)">
                                    <destroy-icon></destroy-icon>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot v-if="users.length !== 0">
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
            users: [],
            currentPage: 1,
            perPage: 1,
            total: 1,
            endpoint: '/api/users?page=',
            isLoading: true,
        }
    },
    mounted() {
        this.getUsers();
    },
    props: {
        destroyMassAction: String,
        publishedMassAction: String,
        notPublishedMassAction: String,
    },
    methods: {
        getUsers() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/users/')
                .then(({data}) => this.getUsersListSuccessResponse(data))
                .catch((response) => this.getUsersListErrorResponse(response));
        },
        getSearchList() {
            this.isLoading = true;
            if (this.search == null || this.search.length === 0) {
                this.getUsers();
            } else {
                axios.get('/api/users/search=' + this.search)
                    .then(({data}) => {
                        this.getUsersListSuccessResponse(data);
                        this.isLoading = false;
                        this.endpoint = '/api/users/search/' + this.search + '?page=';
                    })
                    .catch((response) => this.getUsersListErrorResponse(response));
            }

        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/users', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getUsersListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/users?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getUsersListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        checkAll() {
            if (this.checkedItems.length >= 15) {
                this.checkedItems = [];
            } else {
                const self = this;
                this.users.forEach((key) => {
                    self.checkedItems.push(key.id);
                })
                this.checkedAllActive = !this.checkedAllActive;
            }
        },
        getUsersListSuccessResponse(data) {
            this.users = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
            this.isLoading = false;
        },
        getUsersListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getUsersListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Видалити?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/users/destroy/' + id)
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
        createUser() {
            window.location.href = '/admin/users/create';
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
