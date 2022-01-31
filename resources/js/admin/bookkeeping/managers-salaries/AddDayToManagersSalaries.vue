<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="addDayToManagersSalaries">
                <VueDatePicker
                    v-model="date"
                    format="YYYY-MM-DD"
                    placeholder="Выберите дату"
                />
                <button class="btn btn-danger my-3" type="submit">
                    Добавить
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            date: null,
        }
    },
    methods: {
        addDayToManagersSalaries() {
            axios.post('/api/bookkeeping/managers-salaries/create', {date: this.date})
                .then(({data}) => {
                    if (data.result === true) {
                        this.$swal({
                            'icon': 'success',
                            'title': 'Добавлено!'
                        })
                        window.location.href = '/admin/bookkeeping/managers-salaries';
                    } else {
                        this.$swal({
                            'icon': 'error',
                            'title': 'Ошибка!',
                            'text': 'День уже добавлен'
                        })
                    }
                })
                .catch((response) => console.log(response));
        }
    }
}
</script>
