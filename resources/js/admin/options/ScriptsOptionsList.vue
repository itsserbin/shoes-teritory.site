<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading">
            <div class="mb-3">
                <label for="head_scripts"
                       class="form-label"
                >Head</label>
                <textarea type="text"
                          class="form-control"
                          rows="10"
                          id="head_scripts"
                          v-model="options.head_scripts"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="after_body_scripts"
                       class="form-label"
                >Before body</label>
                <textarea type="text"
                          class="form-control"
                          rows="10"
                          id="after_body_scripts"
                          v-model="options.after_body_scripts"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="footer_scripts"
                       class="form-label"
                >Footer</label>
                <textarea type="text"
                          class="form-control"
                          rows="10"
                          id="footer_scripts"
                          v-model="options.footer_scripts"
                ></textarea>
            </div>

            <button class="btn btn-danger" type="button" @click.prevent="updateOptions">Сохранить</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: true,
            options: {
                head_scripts: null,
                after_body_scripts: null,
                footer_scripts: null,
            }
        }
    },
    mounted() {
        axios.get('/api/options/scripts')
            .then(({data}) => {
                if (data.result.head_scripts) {
                    this.options.head_scripts = data.result.head_scripts.value;
                }
                if (data.result.after_body_scripts) {
                    this.options.after_body_scripts = data.result.after_body_scripts.value;
                }
                if (data.result.footer_scripts) {
                    this.options.footer_scripts = data.result.footer_scripts.value;
                }
                this.isLoading = false;
            })
            .catch((response) => console.log(response))
    },
    methods: {
        updateOptions() {
            this.isLoading = true;

            axios.put('/api/options/scripts/update', this.options)
                .then(() => {
                    this.$swal({
                        'icon': 'success',
                        'title': 'Обновлено!',
                        'text': 'Настройки успешно сохранены :)',
                    });
                    this.isLoading = false;
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        'icon': 'error',
                        'title': 'Ошибка',
                        'text': 'Обратитесь к администратору',
                    });
                    this.isLoading = false;
                })
        }
    }
}
</script>
