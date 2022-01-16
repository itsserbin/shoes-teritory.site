<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateUser(user.id)">
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
                                <option :value="role.id"
                                        v-for="role in roles"
                                        :key="role.id"
                                >{{ role.name }}
                                </option>
                            </select>
                            <input-invalid-feedback :errors="errors.role"></input-invalid-feedback>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger"
                    @click="showNewPassword = true"
                    v-if="!showNewPassword"
            >Сменить пароль
            </button>
            <div class="row" v-if="showNewPassword">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Новый пароль</label>
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
            showNewPassword: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/users/edit/' + id)
            .then(({data}) => this.getUserSuccessResponse(data))
            .catch((response) => this.getUserErrorResponse(response));

        axios.get('/api/roles/list')
            .then(({data}) => this.roles = data.result)
            .catch((response) => console.log(response));
    },
    methods: {
        getUserSuccessResponse(data) {
            this.user = data.result;
            this.user.role = data.result.roles[0].id
            this.isLoading = false;
        },
        getUserErrorResponse(response) {
            console.log(response);
            this.isLoading = false;
        },
        updateUser(id) {
            this.errors = [];
            this.isLoading = true;
            axios.put('/api/users/update/' + id, this.user)
                .then(({data}) => this.getUserUpdateSuccessResponse(data))
                .catch(({response}) => this.getUserUpdateErrorResponse(response));
        },
        getUserUpdateSuccessResponse() {
            this.errors = [];
            this.isLoading = false;
            this.$swal({
                title: 'Обновлено!',
                text: 'Данные были успешно обновлены',
                icon: 'success',
            });
        },
        getUserUpdateErrorResponse(response) {
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
