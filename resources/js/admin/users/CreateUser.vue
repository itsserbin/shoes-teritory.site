<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="createUser()">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Имя</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.name}"
                                       type="text"
                                       v-model="user.name"
                                       placeholder="Введите имя"
                                >
                                <input-invalid-feedback :errors="errors.name"></input-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input class="form-control"
                                       :class="{'is-invalid': errors.email}"
                                       type="text"
                                       v-model="user.email"
                                       placeholder="Введите Email"
                                >
                                <input-invalid-feedback :errors="errors.email"></input-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Роль</label>
                            <select class="form-select" v-model="user.role">
                                <option :value="null" disabled>Не выбрана</option>
                                <option :value="role.id"
                                        v-for="role in roles"
                                        :key="role.id"
                                >{{ role.name }}
                                </option>
                            </select>
                        </div>
                        <input-invalid-feedback :errors="errors.role"></input-invalid-feedback>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Пароль</label>
                        <input class="form-control"
                               type="password"
                               v-model="user.password"
                               :class="{'is-invalid': errors.password}"
                               placeholder="Введите пароль"
                               v-if="!showPassword"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="user.password"
                               :class="{'is-invalid': errors.password}"
                               placeholder="Введите пароль"
                               v-if="showPassword"

                        >
                        <input-invalid-feedback :errors="errors.password"></input-invalid-feedback>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Подтверждение пароля</label>
                        <input class="form-control"
                               type="password"
                               v-model="user.password_confirm"
                               :class="{'is-invalid': errors.password_confirm}"
                               placeholder="Введите подтверждение пароля"
                               v-if="!showPassword"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="user.password_confirm"
                               :class="{'is-invalid': errors.password_confirm}"
                               placeholder="Введите подтверждение пароля"
                               v-if="showPassword"
                        >
                        <input-invalid-feedback :errors="errors.password_confirm"></input-invalid-feedback>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               v-model="showPassword"
                        >
                        <label class="form-check-label">
                            Показать пароль
                        </label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger my-3">
                Сохранить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: null,
                email: null,
                role: null,
                password: null,
                password_confirm: null,
            },
            roles: [],
            errors: [],
            isLoading: true,
            showPassword: false,
        }
    },
    mounted() {
        axios.get('/api/roles/list')
            .then(({data}) => {
                this.roles = data.result;
                this.isLoading = false;
            })
            .catch((response) => console.log(response));
    },
    methods: {
        createUser() {
            this.errors = [];

            this.isLoading = true;
            axios.post('/api/users/create/', this.user)
                .then(({data}) => this.getUserCreateSuccessResponse(data))
                .catch(({response}) => this.getUserCreateErrorResponse(response));
        },
        getUserCreateSuccessResponse() {
            this.errors = [];
            this.isLoading = false;
            this.$swal({
                title: 'Добавлен!',
                text: 'Пользователь успешно добавлен',
                icon: 'success',
            });

            window.location.href = '/admin/users'
        },
        getUserCreateErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность заполненных данных, или же обратитесь к администратору',
                icon: 'error',
            });
        }
    }
}
</script>
