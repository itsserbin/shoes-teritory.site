<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="createFaq">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="faq.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
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
                        <label class="form-label">Вопрос</label>
                        <input class="form-control"
                               type="text"
                               v-model="faq.question.ru"
                               placeholder="Введите вопрос RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="faq.question.ua"
                               placeholder="Введите вопрос UA"
                               v-if="activeLang === 'ua'"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Ответ</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="faq.answer.ru"
                                  placeholder="Введите ответ RU"
                                  v-if="activeLang === 'ru'"
                        ></textarea>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="faq.answer.ua"
                                  placeholder="Введите ответ UA"
                                  v-if="activeLang === 'ua'"
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
            activeLang: 'ua',
            faq: {
                question: {
                    ua: null,
                    ru: null,
                },
                answer: {
                    ua: null,
                    ru: null,
                },
                published: 0,
            },
            errors: [],
            isLoading: false,
        }
    },
    methods: {
        createFaq() {
            this.isLoading = true;
            axios.post('/api/faq/create', this.faq)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Добавлено!',
                        icon: 'success',
                    });
                    window.location.href = '/admin/options/faq';
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
