<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateClient">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Статус</label>
                        <select class="form-select" v-model="client.status">
                            <option :value="newStatus" @click="client.sub_status = null">{{ newStatus }}</option>
                            <option :value="experiencedStatus">{{ experiencedStatus }}</option>
                            <option :value="returnStatus">{{ returnStatus }}</option>
                            <option :value="topStatus" @click="client.sub_status = null">{{ topStatus }}</option>
                            <option :value="blackListStatus" @click="client.sub_status = null">{{ blackListStatus }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Дополнительный статус</label>
                        <select class="form-select" v-model="client.sub_status">
                            <option :value="returnStatusAgreed"
                                    v-if="client.status === returnStatus"
                            >{{ returnStatusAgreed }}
                            </option>
                            <option :value="returnStatusRefused"
                                    v-if="client.status === returnStatus"
                            >{{ returnStatusRefused }}
                            </option>
                            <option :value="returnStatusDidntGetInTouch"
                                    v-if="client.status === returnStatus"
                            >{{ returnStatusDidntGetInTouch }}
                            </option>
                            <option :value="returnStatusNew"
                                    v-if="client.status === returnStatus"
                            >{{ returnStatusNew }}
                            </option>

                            <option :value="experiencedStatusSatisfied"
                                    v-if="client.status === experiencedStatus"
                            >{{ experiencedStatusSatisfied }}
                            </option>
                            <option :value="experiencedStatusAskedForAnExchange"
                                    v-if="client.status === experiencedStatus"
                            >{{ experiencedStatusAskedForAnExchange }}
                            </option>
                            <option :value="experiencedStatusNoResponse"
                                    v-if="client.status === experiencedStatus"
                            >{{ experiencedStatusNoResponse }}
                            </option>
                            <option :value="experiencedStatusNotSatisfied"
                                    v-if="client.status === experiencedStatus"
                            >{{ experiencedStatusNotSatisfied }}
                            </option>
                            <option :value="experiencedStatusInProgress"
                                    v-if="client.status === experiencedStatus"
                            >{{ experiencedStatusInProgress }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Имя</label>
                        <input class="form-control"
                               type="text"
                               v-model="client.name"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Фамилия</label>
                        <input class="form-control"
                               type="text"
                               v-model="client.last_name"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Телефон</label>
                        <div class="d-flex">
                            <input class="form-control"
                                   type="text"
                                   v-model="client.phone"
                            >
                            <a :href="'tel:' + client.phone">
                                <button type="button" class="btn btn-danger">
                                    <telephone-icon></telephone-icon>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control"
                               type="text"
                               v-model="client.email"
                        >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Комментар</label>
                        <textarea class="form-control"
                                  type="text"
                                  v-model="client.comment"
                                  rows="12"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="h3">Список заказов</div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Кол-во товаров</th>
                            <th>Общая сумма</th>
                            <th>Статус</th>
                            <th>Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center" v-for="order in client.orders">
                            <td><a :href="'/admin/orders/edit/' + order.id" target="_blank">{{ order.id }}</a></td>
                            <td>{{ order.total_count }}</td>
                            <td>{{ order.total_price | formatMoney }} грн.</td>
                            <td>{{ order.status }}</td>
                            <td>{{ dateFormat(order.created_at) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row text-center my-3">
                <div class="col-12 col-md-4">
                    <b>Всего покупок: </b>{{ client.number_of_purchases }}
                </div>
                <div class="col-12 col-md-4">
                    <b>Средний чек: </b>{{ client.average_check | formatMoney }} грн.
                </div>
                <div class="col-12 col-md-4">
                    <b>Общий чек: </b>{{ client.whole_check | formatMoney }} грн.

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
            isLoading: true,
            client: {
                name: null,
                last_name: null,
                email: null,
                phone: null,
                comment: null,
                status: null,
                sub_status: null,
                number_of_purchases: null,
                average_check: null,
                whole_check: null,
            },
            errors: []
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/clients/edit/' + id)
            .then(({data}) => {
                this.client = data.result;
                this.isLoading = false;
            })
            .catch((response) => console.log(response));
    },
    props: {
        newStatus: String,
        experiencedStatus: String,
        returnStatus: String,
        topStatus: String,
        blackListStatus: String,

        returnStatusAgreed: String,
        returnStatusRefused: String,
        returnStatusDidntGetInTouch: String,
        returnStatusNew: String,

        experiencedStatusSatisfied: String,
        experiencedStatusAskedForAnExchange: String,
        experiencedStatusNoResponse: String,
        experiencedStatusNotSatisfied: String,
        experiencedStatusInProgress: String,
    },
    methods: {
        updateClient() {
            axios.put('/api/clients/update/' + this.client.id, this.client)
                .then(() => {
                    this.$swal({
                        title: 'Оновлено!',
                        icon: 'success',
                    });
                    this.isLoading = false;
                    this.errors = [];
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    console.log(response);
                    this.$swal({
                        title: 'Помилка',
                        text: 'Перевірте корректність данних або зверніться до адміністратора',
                        icon: 'error',
                    });
                    this.isLoading = false;
                })
        },
        dateFormat(value) {
            return this.$moment(value).format('DD.MM.YYYY');
        },
    }
}
</script>
