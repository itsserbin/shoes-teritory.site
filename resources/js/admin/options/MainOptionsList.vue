<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading">
            <div class="mb-3">
                <label for="schedule"
                       class="form-label"
                >График работы</label>
                <textarea type="text"
                          class="form-control"
                          id="schedule"
                          v-model="options.schedule"
                          placeholder="Введите график работы"
                          rows="4"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="phone"
                       class="form-label"
                >Телефон</label>
                <input type="phone"
                       class="form-control"
                       id="phone"
                       v-model="options.phone"
                       placeholder="Введите телефон компании"
                >
            </div>

            <div class="mb-3">
                <label for="email"
                       class="form-label"
                >Email</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       v-model="options.email"
                       placeholder="Введите e-mail компании"
                >
            </div>

            <div class="mb-3">
                <label for="facebook"
                       class="form-label"
                >Facebook</label>
                <input type="url"
                       class="form-control"
                       id="facebook"
                       v-model="options.facebook"
                       placeholder="Введите ссылку на facebook компании"
                >
            </div>

            <div class="mb-3">
                <label for="instagram"
                       class="form-label"
                >Instagram</label>
                <input type="url"
                       class="form-control"
                       id="instagram"
                       v-model="options.instagram"
                       placeholder="Введите ссылку на instagram компании"
                >
            </div>

            <div class="mb-3">
                <label
                    for="telegram"
                    class="form-label"
                >Telegram</label>
                <input type="url"
                       class="form-control"
                       id="telegram"
                       v-model="options.telegram"
                       placeholder="Введите ссылку на telegram компании"
                >
            </div>

            <div class="mb-3">
                <label for="viber"
                       class="form-label"
                >Viber</label>
                <input type="url"
                       class="form-control"
                       id="viber"
                       v-model="options.viber"
                       placeholder="Введите ссылку на viber компании"
                >
            </div>

            <div class="mb-3">
                <label for="whatsapp"
                       class="form-label"
                >Whatsapp</label>
                <input type="url"
                       class="form-control"
                       id="whatsapp"
                       v-model="options.whatsapp"
                       placeholder="Введите ссылку на whatsapp компании"
                >
            </div>

            <div class="mb-3">
                <label for="fb_messenger"
                       class="form-label"
                >Facebook messenger</label>
                <input type="url"
                       class="form-control"
                       id="fb_messenger"
                       v-model="options.fb_messenger"
                       placeholder="Введите ссылку на facebook messenger компании"
                >
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
                schedule: null,
                phone: null,
                email: null,
                facebook: null,
                instagram: null,
                telegram: null,
                viber: null,
                whatsapp: null,
                fb_messenger: null,
            }
        }
    },
    mounted() {
        axios.get('/api/options/main')
            .then(({data}) => {
                this.options.schedule = data.result.schedule.value;
                this.options.phone = data.result.phone.value;
                this.options.email = data.result.email.value;
                this.options.facebook = data.result.facebook.value;
                this.options.instagram = data.result.instagram.value;
                this.options.viber = data.result.viber.value;
                this.options.whatsapp = data.result.whatsapp.value;
                this.options.fb_messenger = data.result.fb_messenger.value;
                this.isLoading = false;
            })
            .catch((response) => console.log(response))
    },
    methods: {
        updateOptions() {
            this.isLoading = true;

            axios.put('/api/options/main/update', this.options)
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
