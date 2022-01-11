<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="createProduct">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Статус публікації</label>
                    <select class="form-select" v-model="product.published">
                        <option :value="0">Не опубліковано</option>
                        <option :value="1">Опубліковано</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Наявність</label>
                    <select class="form-select" v-model="product.status">
                        <option :value="inStockAvailability">В наявності</option>
                        <option :value="outOfStockAvailability">Не в наявності</option>
                        <option :value="endsAvailability">Закінчуеться</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div v-if="product.preview !== null"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Головне зображення</label>
                        <img :src="'/storage/products/350/' + product.preview" :alt="product.title" class="w-50">
                        <div>
                            <button class="btn" @click="deletePreview">
                                <edit-icon></edit-icon>
                            </button>
                            <a class="btn" v-bind:href="product.preview" target="_blank">
                                <arrow-up-icon></arrow-up-icon>
                            </a>
                        </div>
                    </div>
                    <div v-if="product.preview === null">
                        <label class="form-label">Головне зображення</label>
                        <input class="form-control"
                               type="file"
                               @click="$refs.preview.click()"
                               @change="uploadPreview"
                        >
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="col-12 mb-3">
                        <label class="form-label w-100">Розміри</label>
                        <div class="btn-group" role="group">
                            <input type="checkbox"
                                   class="btn-check"
                                   id="xs"
                                   v-model="product.xs"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xs"
                            >XS</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="s"
                                   v-model="product.s"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="s"
                            >S</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="m"
                                   v-model="product.m"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="m"
                            >M</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="l"
                                   v-model="product.l"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="l"
                            >L</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xl"
                                   v-model="product.xl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xl"
                            >XL</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xxl"
                                   v-model="product.xxl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xxl"
                            >XXL</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xxxl"
                                   v-model="product.xxxl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xxxl"
                            >XXXL</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Категорія товару</label>
                        <select class="form-select" v-model="product.categories" multiple rows="4">
                            <option v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                            >
                                {{ category.title }}
                            </option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Постачальник</label>
                        <select class="form-select" v-model="product.provider_id">
                            <option :value="null">Не вибрано</option>
                            <option v-for="provider in providers"
                                    :key="provider.id"
                                    :value="provider.id"
                            >
                                {{ provider.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label w-100">Обрані кольори</label>
                    <div class="btn-group d-flex flex-wrap" role="group">
                        <div v-for="(product_color,index) in product.colors" class="p-1">
                            <input type="checkbox"
                                   class="btn-check"
                                   :id="product_color.id"
                                   v-model="product.colors"
                                   autocomplete="off"
                                   @click="destroyColorFromProduct(index)"
                            >
                            <label class="btn btn-outline-primary"
                                   :for="product_color.id"
                                   :style="'color:' + product_color.hex + ';' + 'border-color:' + product_color.hex + ';'"
                            >{{ product_color.name }}</label>
                        </div>
                    </div>
                    <label class="form-label w-100">Всі кольори</label>
                    <div class="btn-group d-flex flex-wrap" role="group">
                        <div v-for="(color,index) in colors" class="p-1">
                            <input type="checkbox"
                                   class="btn-check"
                                   :id="color.id"
                                   autocomplete="off"
                                   @click="addColorToProduct(index)"
                            >
                            <label class="btn btn-outline-primary"
                                   :for="color.id"
                                   :style="'color:' + color.hex + ';' + 'border-color:' + color.hex + ';'"
                            >{{ color.name }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Назва товару</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.h1}"
                               type="text"
                               v-model="product.h1"
                               placeholder="Введіть назву товару"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Вкажіть назву товару</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="product.title"
                               placeholder="Введіть META Title"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="product.description"
                                  placeholder="Введіть META Description"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Опис товару</label>
                        <editor :api-key="this.$tinyapi" v-model="product.content" :init="$tinySettings"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Характеристики</label>
                        <editor :api-key="this.$tinyapi" v-model="product.characteristics" :init="$tinySettings"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Таблиця розмірів</label>
                        <editor :api-key="this.$tinyapi" v-model="product.size_table" :init="$tinySettings"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Ціна товару</label>
                    <input class="form-control"
                           :class="{'is-invalid': errors.price}"
                           type="number"
                           v-model="product.price"
                           placeholder="Вкажіть ціну"
                    >
                    <div v-if="errors.price" class="invalid-feedback">Вкажіть ціну товара</div>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Ціна товару зі знижкою</label>
                    <input class="form-control"
                           type="number"
                           v-model="product.discount_price"
                           placeholder="Вкажіть ціну зі знижкою"
                    >
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Ціна закупки</label>
                    <input class="form-control"
                           type="number"
                           v-model="product.trade_price"
                    >
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Артикул</label>
                    <input class="form-control"
                           type="text"
                           v-model="product.vendor_code"
                           placeholder="Вкажіть артикул товару"
                    >
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="images"
                           class="form-label"
                    >Виберіть файли для завантаження</label>
                    <input class="form-control"
                           type="file"
                           id="images"
                           multiple
                           @change="uploadImages"
                    >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                Зберегти
            </button>
        </form>
    </div>
</template>

<script>

import Editor from '@tinymce/tinymce-vue';

export default {
    components: {
        'editor': Editor
    },
    data() {
        return {
            isLoading: true,
            product: {
                xs: null,
                s: null,
                m: null,
                l: null,
                xl: null,
                xxl: null,
                xxxl: null,
                title: null,
                characteristics: null,
                description: null,
                h1: null,
                content: null,
                published: 0,
                preview: null,
                price: null,
                trade_price: null,
                discount_price: null,
                weight: null,
                categories: [],
                vendor_code: null,
                provider_id: null,
                images: [],
                colors: [],
            },
            errors: [],
            categories: [],
            colors: [],
            providers: [],
        }
    },
    props: {
        inStockAvailability: String,
        outOfStockAvailability: String,
        endsAvailability: String,
    },
    mounted() {
        axios.get('/api/categories/all')
            .then(({data}) => this.categories = data.result)
            .catch((response) => console.log(response));

        axios.get('/api/colors/list')
            .then(({data}) => this.colors = data.result)
            .catch((response) => console.log(response));

        axios.get('/api/providers/list')
            .then(({data}) => this.providers = data.result)
            .catch((response) => console.log(response));

        this.isLoading = false;
    },
    methods: {
        uploadImages(event) {
            const self = this;
            Array.from(event.target.files).forEach(function (image) {
                const formData = new FormData();
                formData.append('image', image);
                formData.append('type', 'products');
                axios.post('/api/products/images/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(({data}) => {
                        self.product.images.push({image: data.url});
                    })
                    .catch((response) => console.log(response));
            });
        },
        deletePreview() {
            this.product.preview = null;
        },
        uploadPreview(event) {
            let formData = new FormData();
            formData.append('images', event.target.files[0]);
            axios.post('/api/products/images/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => {
                    if (data.success) {
                        this.product.preview = data.url;
                    }
                })
                .catch((response) => console.log(response));
        },
        addColorToProduct(index) {
            this.product.colors.push(this.colors[index])
            this.colors.splice(index, 1);
        },
        destroyColorFromProduct(index) {
            this.product.colors.splice(index, 1);
            this.colors.push(this.colors[index])
        },
        createProduct() {
            this.isLoading = true;
            this.errors = [];
            axios.post('/api/products/create', this.product)
                .then(() => {
                    this.$swal({
                        title: 'Створено!',
                        icon: 'success',
                    });
                    this.isLoading = false;
                    this.errors = [];
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    console.log(response);
                    this.$swal({
                        title: 'Помилка',
                        text: 'Перевірте корректність данних або зверніться до адміністратора',
                        icon: 'error',
                    });
                    this.isLoading = false;
                })
        }
    }
}
</script>
