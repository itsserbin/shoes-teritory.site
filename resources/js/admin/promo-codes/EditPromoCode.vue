<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.stop.prevent="updatePromoCode">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="promo_code.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Код</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.code}"
                               type="text"
                               v-model="promo_code.code"
                               placeholder="Введіть назву"
                        >
                        <div v-if="errors.code" class="invalid-feedback">Введите код</div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Дата окончания</label>
                        <VueDatePicker
                            v-model="promo_code.end_date"
                            format="DD-MM-YYYY"
                            placeholder="Выберите дату"
                        />
                    </div>
                </div>
            </div>
            <hr class="my-5">
            <div class="row">
                <div class="row mb-3 justify-content-centre">
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   v-model="discountType"
                                   value="percent_discount"
                                   id="flexRadioDefault1"
                                   @click="promo_code.discount_in_hryvnia = null"
                            >
                            <label class="form-check-label" for="flexRadioDefault1">
                                Скидка в процентах
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   v-model="discountType"
                                   value="discount_in_hryvnia"
                                   id="flexRadioDefault2"
                                   @click="promo_code.percent_discount = null"
                            >
                            <label class="form-check-label" for="flexRadioDefault2">
                                Скидка в гривнах
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Скидка в процентах</label>
                        <input class="form-control"
                               type="number"
                               v-model="promo_code.percent_discount"
                               placeholder="Укажите скидку в процентах"
                               v-if="discountType === 'percent_discount'"
                        >
                        <input class="form-control"
                               type="number"
                               v-model="promo_code.percent_discount"
                               placeholder="Укажите скидку в процентах"
                               v-else
                               disabled
                        >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label">Скидка в гривнах</label>
                        <input class="form-control"
                               type="number"
                               v-model="promo_code.discount_in_hryvnia"
                               placeholder="Укажите скидку в гривнах"
                               v-if="discountType === 'discount_in_hryvnia'"
                        >
                        <input class="form-control"
                               type="number"
                               v-model="promo_code.discount_in_hryvnia"
                               placeholder="Укажите скидку в гривнах"
                               v-else
                               disabled
                        >
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                Обновить
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            discountType: 'percent_discount',
            promo_code: {
                code: null,
                percent_discount: null,
                discount_in_hryvnia: null,
                published: 0,
            },
            errors: [],
            isLoading: false,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/promo-codes/edit/' + id)
            .then(({data}) => {
                this.promo_code = data.result;
                if (data.result.discount_in_hryvnia == null) {
                    this.discountType = 'percent_discount'
                } else {
                    this.discountType = 'discount_in_hryvnia'
                }
            })
            .catch(({response}) => console.log(response));
    },
    methods: {
        updatePromoCode() {
            this.isLoading = true;
            axios.put('/api/promo-codes/update/' + this.promo_code.id, this.promo_code)
                .then(() => this.getPromoCodeUpdateSuccessResponse())
                .catch(({response}) => this.getPromoCodeUpdateErrorResponse(response));
        },
        getPromoCodeUpdateSuccessResponse() {
            this.isLoading = false;
            this.$swal({
                title: 'Обновлено!',
                text: 'Промо-код успешно обновлен :)',
                icon: 'success',
            });
        },
        getPromoCodeUpdateErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            console.log(response);
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность введенных данных, или же обратитесь за помощью к администратору',
                icon: 'error',
            });
        },
    }
}
</script>
