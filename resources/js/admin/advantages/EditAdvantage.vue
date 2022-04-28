<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updateAdvantage">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="advantage.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Иконка (SVG)</label>
                        <textarea class="form-control"
                                  type="text"
                                  v-model="advantage.icon"
                                  placeholder="Вставьте иконку"
                        ></textarea>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center my-2">
                <li class="nav-item">
                    <a class="nav-link"
                       href="javascript:"
                       @click="activeLang = 'ua'"
                       :class="{'active':activeLang === 'ua'}"
                    >UA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="javascript:"
                       @click="activeLang = 'ru'"
                       :class="{'active':activeLang === 'ru'}"
                    >RU</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Текст</label>
                        <input class="form-control"
                               type="text"
                               v-model="advantage.text.ru"
                               placeholder="Введите текст RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="advantage.text.ua"
                               placeholder="Введите текст UA"
                               v-if="activeLang === 'ua'"
                        >
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
            activeLang: 'ua',
            advantage: {
                text: {
                    ua: null,
                    ru: null,
                },
                icon: null,
                published: 0,
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted(){
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

      axios.get('/api/advantages/edit/' + id)
          .then(({data}) => this.advantage = data.result)
          .catch((response) => console.log(response));
    },
    methods: {
        updateAdvantage() {
            this.isLoading = true;
            axios.put('/api/advantages/update/' + this.advantage.id, this.advantage)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Обновлено!',
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
