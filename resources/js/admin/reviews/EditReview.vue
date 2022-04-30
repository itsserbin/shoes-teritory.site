<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateReview">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Статус</label>
                        <select class="form-select" v-model="review.status">
                            <option :value="0">Не опубликовано</option>
                            <option :value="1">Опубликовано</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Имя</label>
                        <input class="form-control"
                               type="text"
                               v-model="review.name"
                               placeholder="Введите имя"
                        >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Отзыв</label>
                        <textarea class="form-control"
                                  type="text"
                                  v-model="review.comment"
                                  placeholder="Введите отзыв"
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
            isLoading: true,
            review: {
                name: null,
                comment: null,
                status: 0,
            },
            errors: []
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/reviews/edit/' + id)
            .then(({data}) => {
                this.review = data.result;
                this.isLoading = false;
            })
            .catch((response) => console.log(response));
    },
    methods: {
        updateReview() {
            axios.put('/api/reviews/update/' + this.review.id, this.review)
                .then(() => {
                    this.$swal({
                        title: 'Обновлено!',
                        icon: 'success',
                    });
                    this.isLoading = false;
                    this.errors = [];
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    console.log(response);
                    this.$swal({
                        title: 'Ошибка',
                        icon: 'error',
                    });
                    this.isLoading = false;
                })
        }
    }
}
</script>
