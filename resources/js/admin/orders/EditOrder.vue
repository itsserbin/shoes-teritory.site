<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateOrder">

            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label" for="name">Имя</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               v-model="order.client.name"
                               disabled
                        >
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label" for="last_name">Фамилия</label>
                        <input type="text"
                               class="form-control"
                               id="last_name"
                               v-model="order.client.last_name"
                               disabled
                        >
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label" for="phone">Номер телефона</label>
                        <div class="d-flex">
                            <input type="text"
                                   class="form-control"
                                   id="phone"
                                   v-model="order.client.phone"
                                   disabled
                            >
                            <a :href="'tel:' + order.client.phone">
                                <button type="button" class="btn btn-danger">
                                    <telephone-icon></telephone-icon>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label w-100">&nbsp;</label>
                        <a :href="'/admin/clients/edit/' + order.client_id" target="_blank">
                            <button type="button" class="btn btn-danger">
                                Редактировать данные клиента
                            </button>
                        </a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group my-3">
                        <label class="form-label">Статус клиента:</label>
                        <select class="form-control" id="status" v-model="order.status">
                            <option :value="statusNew">{{ statusNew }}</option>
                            <option :value="statusAwaitingDispatch">{{ statusAwaitingDispatch }}</option>
                            <option :value="statusAwaitingPrepayment">{{ statusAwaitingPrepayment }}</option>
                            <option :value="statusCanceled">{{ statusCanceled }}</option>
                            <option :value="statusAtThePostOffice">{{ statusAtThePostOffice }}</option>
                            <option :value="statusDone">{{ statusDone }}</option>
                            <option :value="statusOnTheRoad">{{ statusOnTheRoad }}</option>
                            <option :value="statusProcessed">{{ statusProcessed }}</option>
                            <option :value="statusReturn">{{ statusReturn }}</option>
                            <option :value="statusTransferredToSupplier">{{ statusTransferredToSupplier }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group my-3">
                        <label class="form-label">Менеджер клиента:</label>
                        <select class="form-control" id="status" v-model="order.manager_id">
                            <option :value="null" disabled>Не выбран</option>
                            <option :value="manager.id"
                                    v-for="manager in managers"
                                    :key="manager.id"
                            >{{ manager.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group d-flex align-items-center h-100 mt-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   v-model="order.parcel_reminder"
                            >
                            <label class="form-check-label">
                                Дожим до выкупа
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label class="form-label" for="city">Город</label>
                        <input type="text" class="form-control" id="city" name="city"
                               v-model="order.city">
                    </div>


                    <div class="form-group my-3">
                        <label class="form-label" for="postal_office">Номер почтового отеделения</label>
                        <input type="text" class="form-control" id="postal_office" name="postal_office"
                               v-model="order.postal_office">
                    </div>

                    <div class="form-group my-3">
                        <label class="form-label" for="waybill">Номер накладной</label>
                        <input type="text" class="form-control" id="waybill" name="waybill"
                               v-model="order.waybill">
                    </div>
                    <div v-if="!order.sms_waybill_status" v-show="order.waybill !== null">
                        <a
                            href="javascript:"
                            @click.prevent="sendWaybill(order.client.phone,order.waybill)"
                        >Отправить ТТН клиенту</a>
                    </div>
                    <div v-if="order.sms_waybill_status">
                        ТТН отправлена (<a href="javascript:"
                                           @click.prevent="sendWaybill(order.client.phone,order.waybill)"
                    >Отправить повторно</a>)
                    </div>

                    <div class="row align-items-center">
                        <div class="col-12 col-md-6">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="sale_of_air"
                                       v-model="order.sale_of_air"
                                >
                                <label class="form-check-label"
                                       for="sale_of_air"
                                >
                                    Доп.продажа воздуха
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div v-if="order.sale_of_air" class="w-100">
                                <input type="text"
                                       id="sale_of_air_price"
                                       v-model="order.sale_of_air_price"
                                       class="form-control"
                                       placeholder="Сумма скидки (грн.)"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label class="form-label">Комментарий</label>
                        <textarea rows="8"
                                  class="form-control"
                                  id="comment"
                                  v-model="order.comment">
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <button class="btn btn-danger" type="button" @click="modalAddProductItem">
                        Добавить товар
                    </button>
                </div>
                <div class="modal active-modal" v-if="showAddProductItem">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button"
                                        class="btn-close"
                                        @click="showAddProductItem = false"
                                >
                                </button>
                            </div>
                            <div class="modal-body text-start">
                                <div class="mb-3">
                                    <model-list-select
                                        :list="products"
                                        v-model="item.id"
                                        option-value="id"
                                        :custom-text="h1AndCodeAndId"
                                        placeholder="Выберите товар"
                                    >
                                    </model-list-select>
                                </div>
                                <div class="form-group" v-if="item.id">
                                    <label for="item_size" class="form-label">Размер</label>
                                    <input type="text"
                                           id="item_size"
                                           v-model="item.size"
                                           class="form-control">

                                    <label for="item_color" class="form-label mt-3">Цвет</label>
                                    <input type="text"
                                           id="item_color"
                                           v-model="item.color"
                                           class="form-control">

                                    <label for="item_count" class="form-label mt-3">Количество</label>
                                    <input type="text"
                                           id="item_count"
                                           v-model="item.count"
                                           class="form-control">

                                    <div class="form-check mt-3">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="item_resale"
                                               v-model="item.resale"
                                        >
                                        <label class="form-check-label"
                                               for="item_resale"
                                        >
                                            Доп. продажа
                                        </label>
                                    </div>

                                    <div v-if="item.resale">
                                        <label for="item_discount" class="form-label mt-3">Сумма скидки (грн.)</label>
                                        <input type="text"
                                               id="item_discount"
                                               v-model="item.discount"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        @click="showAddProductItem = false"
                                >Закрыть
                                </button>
                                <button type="button"
                                        @click.prevent="addOrderItems"
                                        class="btn btn-danger"
                                >Добавить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2 ">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Фото</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Сумма</th>
                                <th>Цвет</th>
                                <th>Размер</th>
                                <th>Допродажа</th>
                                <th>Скидка</th>
                                <th>Артикул</th>
                                <th>Поставщик</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,index) in order.items" :key="item.id" style="vertical-align: middle;">
                                <td>
                                    <a :href="'/product/' + item.product_id"
                                       target="_blank">{{ item.product.h1 }}</a>
                                </td>
                                <td>
                                    <img :src="'/storage/products/55/' + item.product.preview"
                                         :alt="item.product.h1"
                                         class="w-50"
                                    >
                                </td>
                                <td>{{ item.count }}</td>
                                <td>{{ item.sale_price | formatMoney }} грн.</td>
                                <td>{{ item.total_price | formatMoney }} грн.</td>
                                <td><span v-for="color in item.color">{{ color }}</span></td>
                                <td><span v-for="size in item.size">{{ size }}</span></td>
                                <td>
                                    <span v-if="item.resale !== 0">Да</span>
                                    <span v-else>Нет</span>
                                </td>
                                <td>
                                    <span v-if="item.resale === 0">Нет</span>
                                    <span v-else>{{ item.discount }}</span>
                                </td>
                                <td>{{ item.product.vendor_code }}</td>
                                <td>{{ item.product.providers.name }}</td>
                                <td>
                                    <a class="btn" href="javascript:;" @click="onEdit(item.id, index)">
                                        <edit-icon></edit-icon>
                                    </a>
                                    <a class="btn" href="javascript:;" @click="onDelete(item.id)">
                                        <destroy-icon></destroy-icon>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal active-modal" v-if="showEditProductItem">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button"
                                                class="btn-close"
                                                @click="showEditProductItem = false"
                                        >
                                        </button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <label for="size" class="form-label">Размер</label>
                                        <input type="text"
                                               id="size"
                                               v-model="product.size"
                                               class="form-control">

                                        <label for="color" class="form-label mt-3">Цвет</label>
                                        <input type="text"
                                               id="color"
                                               v-model="product.color"
                                               class="form-control">

                                        <label for="count" class="form-label mt-3">Количество</label>
                                        <input type="text"
                                               id="count"
                                               v-model="product.count"
                                               class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                @click="showEditProductItem = false"
                                        >Закрыть
                                        </button>
                                        <button type="button"
                                                @click.prevent="updateOrderItems"
                                                class="btn btn-primary"
                                        >Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row text-center mb-3">
                <div class="col-12 col-md-4">
                    <b>Товаров: </b> {{ order.total_count }}
                </div>
                <div class="col-12 col-md-4">
                    <b>Общая сумма: </b> {{ order.total_price | formatMoney }}
                </div>

                <div class="col-12 col-md-4">
                    <b>Промо-код: </b> {{ order.promo_code ? order.promo_code : 'Отсутствует' }}
                </div>
            </div>
            <button type="submit" class="btn btn-danger">Сохранить</button>

        </form>
    </div>
</template>

<script>
import {ModelListSelect} from 'vue-search-select'


export default {
    data() {
        return {
            host: window.location.origin + '/',
            order: {
                id: null,
                status: null,
                city: null,
                postal_office: null,
                waybill: null,
                manager_id: null,
                comment: null,
                updated_at: null,
                modified_by: null,
                parcel_reminder: 0,
                sale_of_air: 0,
                sale_of_air_price: null,
                items: [],
            },
            product: {
                id: null,
                size: null,
                color: null,
                count: null
            },
            item: {
                id: null,
                size: null,
                color: null,
                count: 1,
                discount: null,
                resale: 0,
            },
            products: [],
            managers: [],
            isLoading: true,
            showEditProductItem: false,
            showAddProductItem: false,
        }
    },
    components: {
        ModelListSelect
    },
    props: {
        userName: String,
        destroyMassAction: String,
        statusNew: String,
        statusAtThePostOffice: String,
        statusAwaitingDispatch: String,
        statusAwaitingPrepayment: String,
        statusCanceled: String,
        statusDone: String,
        statusOnTheRoad: String,
        statusProcessed: String,
        statusReturn: String,
        statusTransferredToSupplier: String,
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        this.getOrder(id);

        axios.get('/api/users/list/managers')
            .then(({data}) => this.managers = data.result)
            .catch((response) => console.log(response));
    },
    methods: {
        h1AndCodeAndId(item) {
            return `${item.h1} - ${item.vendor_code}/${item.id}`;
        },
        addOrderItems() {
            axios.post('/api/order-items/add/' + this.order.id, this.item)
                .then(() => {
                    this.$swal({
                        'icon': 'success',
                        'title': 'Добавлено!',
                        'text': 'Товар успешно добавлен к заказу :)',
                    });
                    this.getOrder(this.order.id);
                    this.item = {};
                    this.item.count = 1;
                    this.showAddProductItem = false;
                })
                .catch((response) => {
                    console.log(response);
                    this.$swal({
                        'icon': 'error',
                        'title': 'Ошибка!',
                        'text': 'Проверьте корректность данных или обратитесь за помощью к администратору',
                    });
                })
        },
        modalAddProductItem() {
            this.showAddProductItem = true;

            axios.get('/api/products/list')
                .then(({data}) => this.products = data.result)
                .catch((response) => console.log(response));
        },
        getOrder(id) {
            axios.get('/api/orders/edit/' + id)
                .then(({data}) => this.getOrderSuccessResponse(data))
                .catch((response) => this.getOrderErrorResponse(response));
        },
        sendWaybill(phone) {
            if (this.order.waybill !== null) {
                axios.post('/admin/notify-waybill', {
                    phone: phone,
                    waybill: this.order.waybill,
                    order_id: this.order.id
                })
                    .then(({data}) => {
                        if (data.success === true) {
                            this.$swal({
                                'icon': 'success',
                                'title': 'Отправлено!',
                                'text': 'Номер накладной успешно отправлен клиенту',
                            })
                        } else {
                            this.$swal({
                                'icon': 'error',
                                'title': 'Ошибка',
                                'text': 'Обратитесь к администратору',
                            })
                        }
                        axios.put('/api/orders/update/' + this.order.id, this.order)
                        this.getOrder(this.order.id);
                    })
                    .catch((response) => {
                        this.$swal({
                            'icon': 'error',
                            'title': 'Ошибка',
                            'text': 'Обратитесь к администратору',
                        })
                        console.log(response)
                    });
            }
        },
        onEdit(product_id, index) {
            this.showEditProductItem = true;
            this.product.id = product_id;
            this.product.index = index;
            this.product.size = this.order.items[index].size;
            this.product.color = this.order.items[index].color;
            this.product.count = this.order.items[index].count;
        },
        getOrderSuccessResponse(data) {
            this.order = data.result;
            if (data.result.manager) {
                this.order.manager_id = data.result.manager.id
            }
            this.isLoading = false;
        },
        getOrderErrorResponse(response) {
            console.log(response)
        },
        updateOrderItems() {
            axios.put('/api/order-items/update/' + this.product.id, {
                count: this.product.count,
                size: this.product.size,
                color: this.product.color
            })
                .then(() => {
                    this.order.items[this.product.index].size = this.product.size;
                    this.order.items[this.product.index].color = this.product.color;
                    this.order.items[this.product.index].count = this.product.count;
                    this.showEditProductItem = false;
                    this.product.id = null;
                    this.product.index = null;
                    this.product.size = null;
                    this.product.color = null;
                    this.product.count = null;
                })
                .catch((response) => console.log(response));
        },
        onDelete(id) {
            this.$swal({
                title: 'Вы точно хотите удалить товар из заказа?',
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/order-items/destroy/' + id + '/' + this.order.id)
                        .then(() => {
                            this.$swal({
                                title: 'Удалено!',
                                icon: 'success',
                                showCancelButton: false,
                            });
                            this.getOrder(this.order.id);
                        })
                        .catch((response) => {
                            console.log(response);
                            this.$swal({
                                title: 'Ошибка',
                                icon: 'error',
                                showCancelButton: false,
                            });
                        });
                }
            });
        },
        updateOrder() {
            axios.put('/api/orders/update/' + this.order.id, this.order)
                .then(() => {
                    this.$swal({
                        title: 'Обновлено!',
                        text: 'Данные успешно обновлены',
                        icon: 'success',
                    });
                    this.getOrder(this.order.id);
                })
                .catch((response) => console.log(response));
        },
    }
}
</script>
