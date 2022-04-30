<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updateColor">
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Название</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.name}"
                               type="text"
                               v-model="color.name"
                               placeholder="Введите название"
                        >
                        <input-invalid-feedback v-if="errors.code" :errors="errors.code"></input-invalid-feedback>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">HEX код</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.hex}"
                               type="text"
                               v-model="color.hex"
                               placeholder="Введите HEX код"
                        >
                        <input-invalid-feedback v-if="errors.hex" :errors="errors.hex"></input-invalid-feedback>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Отрисовка оттенка</label>
                    <div class="rounded mx-auto border w-100 h-50"
                         v-if="color.hex"
                         :style="'background-color:' + color.hex"
                    ></div>
                    <div v-else>Укажите HEX код</div>
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
            color: {
                name: null,
                hex: null,
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/colors/edit/' + id)
            .then(({data}) => this.color = data.result)
            .catch((response) => console.log(response))
    },
    methods: {
        updateColor() {
            this.isLoading = true;
            axios.put('/api/colors/update/' + this.color.id, this.color)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Обновлено!',
                        icon: 'success',
                    });
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    console.log(response);
                    this.isLoading = false;
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
