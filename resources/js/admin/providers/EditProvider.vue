<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updateProvider">
            <div class="row mb-3">
                <div class="col-12 col-md-10">
                    <div class="form-group">
                        <label class="form-label">Название</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.name}"
                               type="text"
                               v-model="provider.name"
                               placeholder="Ведите название"
                        >
                        <div v-if="errors.name" class="invalid-feedback">Ведите название</div>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group">
                        <label class="form-label">Время отправки</label>
                        <input class="form-control"
                               type="text"
                               v-model="provider.time_of_dispatch"
                        >
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Каталог</label>
                        <input class="form-control"
                               type="text"
                               v-model="provider.catalog"
                               placeholder="Укажите ссылку на каталог"
                        >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Наличие</label>
                        <input class="form-control"
                               type="text"
                               v-model="provider.availability"
                               placeholder="Укажите ссылку на наличие"
                        >
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Предоплата</label>
                    <select class="form-select" v-model="provider.prepayment">
                        <option :value="0">Нет</option>
                        <option :value="1">Есть</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Сумма предоплаты</label>
                        <input class="form-control"
                               type="text"
                               v-model="provider.prepayment_sum"
                               v-if="provider.prepayment === 1"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="provider.prepayment_sum"
                               disabled
                               v-else
                        >
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Оплата возврата</label>
                    <select class="form-select" v-model="provider.refunds">
                        <option :value="0">Нет</option>
                        <option :value="1">Есть</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Сумма оплаты</label>
                        <input class="form-control"
                               type="text"
                               v-model="provider.refunds_sum"
                               v-if="provider.refunds === 1"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="provider.refunds_sum"
                               disabled
                               v-else
                        >
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Контакты</label>
                        <textarea
                            class="form-control"
                            type="text"
                            rows="4"
                            v-model="provider.contacts"
                        ></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Комментарий</label>
                        <textarea
                            class="form-control"
                            type="text"
                            rows="4"
                            v-model="provider.comment"
                        ></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger">
                Сохранить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            provider: {
                name: null,
                catalog: null,
                time_of_dispatch: null,
                availability: null,
                prepayment: 0,
                prepayment_sum: null,
                refunds: 0,
                refunds_sum: null,
                contacts: null,
                comment: null,
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/providers/edit/' + id)
            .then(({data}) => {
                this.provider = data.result;
                this.isLoading = false;
            })
            .catch((response) => console.log(response));
    },
    methods: {
       updateProvider() {
            this.isLoading = true;
            axios.put('/api/providers/update/' + this.provider.id, this.provider)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Добавлено!',
                        text: 'Поставщик успешно обновлен :)',
                        icon: 'success',
                    });
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    this.isLoading = false;
                    console.log(response);
                    this.$swal({
                        title: 'Произошла ошибка :(',
                        text: 'Проверьте корректность введенных данных, или же обратитесь за помощью к администратору',
                        icon: 'error',
                    });
                });
        }
    }
}
</script>
