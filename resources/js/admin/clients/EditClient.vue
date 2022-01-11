<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateClient">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Статус</label>
                        <select class="form-select" v-model="client.status">
                            <option :value="newStatus">{{ newStatus }}</option>
                            <option :value="experiencedStatus">{{ experiencedStatus }}</option>
                            <option :value="returnStatus">{{ returnStatus }}</option>
                            <option :value="topStatus">{{ topStatus }}</option>
                            <option :value="blackListStatus">{{ blackListStatus }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Імʼя</label>
                        <input class="form-control"
                               type="text"
                               v-model="client.name"
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
                        <label class="form-label">Місто</label>
                        <input class="form-control"
                               type="text"
                               v-model="client.city"
                        >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Комментар</label>
                        <textarea class="form-control"
                                  type="text"
                                  v-model="client.comment"
                                  rows="9"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr class="text-center">
                            <th>Кіль-сть покупок</th>
                            <th>Середній чек</th>
                            <th>Загальний чек</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td>{{client.number_of_purchases}}</td>
                            <td>{{client.average_check}}</td>
                            <td>{{client.whole_check}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                Зберегти
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
                comment: null,
                status: 0,
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
        }
    }
}
</script>
