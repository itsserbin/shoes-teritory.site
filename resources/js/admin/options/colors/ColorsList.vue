<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div v-if="!isLoading">
            <div class="row mb-3" v-if="colors.length !== 0">
                <div class="col">
                    <button
                        @click="createColor"
                        class="btn btn-danger w-25">
                        Добавить цвет
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead class="text-center">
                    <tr style="vertical-align: middle;">
                        <th>Оттенок</th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-1">Название</div>
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
                                <div class="mr-1">HEX</div>
                                <a href="javascript:" class="text-dark" @click="sort('hex','asc')">
                                    <arrow-up-icon></arrow-up-icon>
                                </a>
                                <a href="javascript:" class="text-dark" @click="sort('hex','desc')">
                                    <arrow-down-icon></arrow-down-icon>
                                </a>
                            </div>
                        </th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-if="colors.length === 0">
                        <td colspan="10">
                            <div class="row justify-content-center flex-column align-content-center">
                                <div class="h2">Цвета еще не добавлены</div>
                            </div>
                            <button
                                @click="createColor"
                                class="btn btn-danger w-25 m-auto"
                            >
                                Добавить цвет
                            </button>
                        </td>
                    </tr>
                    <tr v-for="color in colors" :key="color.id" style="vertical-align: middle;">
                        <td>
                            <div class="rounded mx-auto border"
                                 :style="'background-color:' + color.hex +'; width:20px;height:20px'"
                            ></div>
                        </td>
                        <td>
                            <a :href="'/admin/options/colors/edit/' + color.id">
                                {{ color.name }}
                            </a>
                        </td>
                        <td>{{color.hex}}</td>
                        <td>
                            <a href="javascript:" @click="onDelete(color.id)">
                                <destroy-icon></destroy-icon>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="colors.length !== 0">
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
            colors: [],
            isLoading: true,
            endpoint: '/api/colors?page=',
            currentPage: 1,
            perPage: 1,
            total: 1,
        }
    },
    mounted() {
        this.getColors();
    },
    methods: {
        createColor() {
            window.location.href = '/admin/options/colors/create';
        },
        sort(value, param) {
            this.isLoading = true;
            axios.get('/api/colors', {
                params:
                    {
                        sort: value,
                        param: param
                    }
            })
                .then(({data}) => {
                    this.getColorsListSuccessResponse(data);
                    this.isLoading = false;
                    this.endpoint = '/api/colors?sort=' + value + '&param=' + param + '&page=';
                })
                .catch((response) => this.getColorsListErrorResponse(response));
        },
        getColors() {
            this.search = null;
            this.isLoading = true;
            axios.get('/api/colors')
                .then(({data}) => {
                    this.getColorsListSuccessResponse(data);
                    this.endpoint = '/api/colors?page=';
                })
                .catch((response) => this.getColorsListErrorResponse(response));
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
        getColorsListSuccessResponse(data) {
            this.isLoading = false;
            this.colors = data.result.data;
            this.total = data.result.total;
            this.currentPage = data.result.current_page;
            this.perPage = data.result.per_page;
        },
        getColorsListErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        fetch(page = 1) {
            this.isLoading = true;
            axios.get(this.endpoint + page)
                .then(({data}) => this.getColorsListSuccessResponse(data));
        },
        onDelete(id) {
            this.$swal({
                title: 'Удалить?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/colors/destroy/' + id)
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
        }
    }
}
</script>
