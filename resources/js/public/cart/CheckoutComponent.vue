<template>
    <div>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="order-card border rounded m-2 " v-for="item in cart.list" :key="item.id">
                    <div class="d-flex">
                        <div class="order-img w-25 d-flex">
                            <img class="w-100" :alt="item.name"
                                 :src="item.image ? item.image : '/images/no-image.png'"
                                 style="object-fit: cover;">
                        </div>
                        <div class="order-content d-flex flex-column p-3 w-100">
                            <div class="h5">
                                <a v-bind:href="item.alias" class="text-dark text-decoration-none"
                                   target="_blank">{{ item.name }}</a>
                            </div>
                            <div>Цвет: <span v-for="color in item.color">{{ color }}</span></div>
                            <div>Размер: <span v-for="size in item.size">{{ size }}</span></div>
                            <div>Цена: ₴ {{ item.price }}</div>
                            <div>Кол-во: {{ item.count }}</div>
                            <div>Итого: ₴ {{ item.price * item.count }}</div>
                        </div>
                        <div class="d-flex">
                            <button type="button"
                                    class="btn"
                                    @click.prevent="removeFromCart(item.id)"
                            >
                                <destroy-icon></destroy-icon>
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2">Итого</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Товаров</td>
                        <td>{{ cart.totalCount }}</td>
                    </tr>
                    <tr>
                        <td><b>К оплате</b></td>
                        <td><b>₴ {{ cart.totalPrice }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-md-6 mb-3 align-items-center justify-content-center d-flex">
                <loader v-if="isLoading"></loader>
                <form @submit.stop.prevent="sendOrder" v-if="!isLoading" class="w-100">
                    <div class="h3">Контактные данные</div>

                    <label class="form-label">ФИО</label>
                    <div class="input-group mb-3">
                        <input
                            class="form-control"
                            v-model="order.name"
                            placeholder="Введите свое ФИО"
                        >
                        <span v-if="errors.name" class="has-error text-danger">Введите Ваше ФИО</span>
                    </div>

                    <label class="form-label">Телефон</label>
                    <div class="input-group mb-3">
                        <input
                            class="form-control"
                            id="input-phone"
                            v-model="order.phone"
                            placeholder="Введите свой телефон"
                        >

                        <span v-if="errors.phone" class="has-error text-danger">Введите Ваш телефон</span>
                    </div>

                    <label class="form-label">Город</label>
                    <div class="input-group mb-3">
                        <input
                            class="form-control"
                            v-model="order.city"
                            placeholder="Введите город доставки"
                        >

                        <span v-if="errors.city" class="has-error text-danger">Укажите город доставки</span>

                    </div>

                    <label class="form-label">Отделение НоваПошта</label>
                    <div class="input-group mb-3">
                        <input
                            class="form-control"
                            v-model="order.postal_office"
                            placeholder="Введите номер отделение НоваПошта"
                            aria-describedby="input-postal_office-live-feedback"
                        >

                        <span v-if="errors.postal_office"
                              class="has-error text-danger">Укажите отделение НоваПошта</span>
                    </div>
                    <div class="row justify-content-center justify-content-md-end mb-5 text-center text-md-between">
                        <div class="col-6">
                            <button
                                type="submit"
                                class="btn btn-outline-success">
                                Оформить заказ
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>

</template>

<script>
import Inputmask from 'inputmask';
import destroyIcon from '../../components/icons/DestroyIcon';

export default {
    components: {
        'destroy-icon': destroyIcon
    },
    data() {
        return {
            host: window.location.origin + '/',
            isLoading: false,
            cart: this.$store.state,
            errors: [],
            order: {
                name: null,
                phone: null,
                city: null,
                postal_office: null,
            }
        }
    },
    mounted() {
        new Inputmask("+38 (999) 999-99-99").mask(document.getElementById('input-phone'));
    },
    methods: {
        removeFromCart(id) {
            axios.delete('/api/v1/cart/delete/' + id)
                .then(() => this.deleteCartListSuccessResponse())
                .catch((response) => this.deleteCartListErrorResponse(response));
        },
        deleteCartListSuccessResponse() {
            this.$store.commit('loadCart');
        },
        deleteCartListErrorResponse(response) {
            console.log(response);
        },
        sendOrder() {
            this.isLoading = true;
            axios.post('/api/v1/order/create', this.order)
                .then(() => this.sendFormSuccessResponse())
                .catch(({response}) => this.sendFormErrorResponse(response));
        },
        sendFormSuccessResponse() {
            this.isLoading = false;
            this.$swal({
                title: 'Отправлено!',
                text: 'Ваша заявка отправлена :)',
                icon: 'success',
            });
            window.location.href = '/send-form';
        },
        sendFormErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            this.$swal({
                title: 'Произошла ошибка :(',
                text: 'Проверьте корректность введенных данных, или же обратитесь по контактным данным',
                icon: 'error',
            });
        }
    }
}
</script>
