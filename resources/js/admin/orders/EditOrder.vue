<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateOrder">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label">Статус клиента:</label>
                        <select class="form-control" id="status" v-model="order.status">
                            <option :value="statusNew">{{statusNew}}</option>
                            <option :value="statusAwaitingDispatch">{{statusAwaitingDispatch}}</option>
                            <option :value="statusAwaitingPrepayment">{{statusAwaitingPrepayment}}</option>
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
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label" for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name"
                               v-model="order.name">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group my-3">
                        <label class="form-label" for="phone">Номер телефона</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               v-model="order.phone">
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
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label class="form-label">Комментарий</label>
                        <textarea rows="8"
                                  class="form-control"
                                  id="comment"
                                  name="comment"
                                  v-model="order.comment">
                        </textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-5 py-3 ">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Фото</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Цвет</th>
                                <th>Размер</th>
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
                                    <img :src="item.product.preview"
                                         :alt="item.product.h1"
                                         class="w-50"
                                    >
                                </td>
                                <td>{{ item.count }}</td>
                                <td>{{ item.sale_price }}</td>
                                <td><span v-for="color in item.color">{{ color }}</span></td>
                                <td><span v-for="size in item.size">{{ size }}</span></td>
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
            <button type="submit" class="btn btn-danger">Сохранить</button>

        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            host: window.location.origin + '/',
            order: {
                id: null,
                status: null,
                name: null,
                phone: null,
                city: null,
                postal_office: null,
                waybill: null,
                comment: null,
                updated_at: null,
                modified_by: null,
                items: [],
            },
            product: {
                id: null,
                size: null,
                color: null,
                count: null
            },
            isLoading: true,
            showEditProductItem: false,
        }
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

        axios.get('/api/orders/edit/' + id)
            .then(({data}) => this.getOrderSuccessResponse(data))
            .catch((response) => this.getOrderErrorResponse(response));
    },
    methods: {
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
            if (confirm('Вы точно хотите удалить товар из заказа?')) {
                axios.delete('/api/order-items/destroy/' + id)
                    .then(() => this.getItems(this.order.id))
                    .catch((response) => this.getOrderItemsErrorResponse(response));
            }
        },
        updateOrder() {
            axios.put('/api/orders/update/' + this.order.id, [this.order, {userName: this.userName}])
                .then(() => this.$swal({
                    title: 'Обновлено!',
                    text: 'Данные успешно обновлены',
                    icon: 'success',
                }))
                .catch((response) => console.log(response));
        },
    }
}
</script>
