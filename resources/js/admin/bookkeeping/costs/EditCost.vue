<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateCost">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label>Категория</label>
                        <model-list-select :list="costCategories"
                                           v-model="costItem.cost_category_id"
                                           option-value="id"
                                           option-text="title"
                                           placeholder="Выберите категорию"
                        ></model-list-select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label>Дата</label>
                        <VueDatePicker
                            v-model="costItem.date"
                            format="YYYY-MM-DD"
                            placeholder="Введите дату"
                        />
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group my-3">
                        <label for="quantity" class="w-100">Количество</label>
                        <div class="btn-group">
                            <input type="number"
                                   class="form-control"
                                   id="quantity"
                                   placeholder="Введите количество"
                                   v-model="costItem.quantity"
                            >
                            <button type="button" class="btn btn-outline-danger" disabled>шт.</button>

                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group my-3">
                        <label for="sum" class="w-100">Сумма</label>
                        <div class="btn-group">
                            <input type="number"
                                   class="form-control"
                                   id="sum"
                                   placeholder="Введите сумму"
                                   v-model="costItem.sum"
                            >
                            <button type="button" class="btn btn-outline-danger" disabled>грн.</button>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group my-3">
                        <label for="total" class="w-100">Итого</label>
                        <div class="btn-group">
                            <input type="number"
                                   class="form-control"
                                   id="total"
                                   placeholder="Введите сумму"
                                   disabled
                                   :value="totalSum"
                            >
                            <button type="button" class="btn btn-outline-danger" disabled>грн.</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group my-3">
                        <label>Комментарий</label>
                        <textarea type="text"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Введите комментарий"
                                  v-model="costItem.comment"
                        ></textarea>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger my-3" type="submit">
                Обновить
            </button>
        </form>
    </div>

</template>

<script>
export default {
    data() {
        return {
            costItem: {
                cost_category_id: null,
                date: null,
                sum: null,
                quantity: null,
                comment: null,
                total: null,
            },
            errors: [],
            costCategories: [],
            isLoading: false,
        }
    },
    computed: {
        totalSum() {
            return this.costItem.total = this.costItem.sum * this.costItem.quantity;
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/bookkeeping/costs/edit/' + id)
            .then(({data}) => {
                this.costItem = data.result;
                this.isLoading = false;
            })
            .catch(({response}) => {
                console.log(response);
                this.isLoading = false;
            });

        axios.get('/api/bookkeeping/costs/categories/list')
            .then(({data}) => this.costCategories = data.result)
            .catch(({response}) => console.log(response));
    },
    methods: {
        updateCost() {
            this.isLoading = true;
            axios.put('/api/bookkeeping/costs/update/' + this.costItem.id, this.costItem)
                .then(() => {
                    this.$swal({
                        icon: 'success',
                        title: 'Трата успешно обновлена!'
                    });
                    this.isLoading = false;
                })
                .catch(({response}) => {
                    console.log(response);
                    this.errors = response.data;
                    this.isLoading = false;
                })
        }
    }
}
</script>

<style>
.vd-wrapper{
    border-radius: 0.25rem !important;
    border: 1px solid #dee2e6 !important;
}
</style>
