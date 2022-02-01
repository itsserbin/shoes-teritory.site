<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="createProduct">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Статус публикации</label>
                    <select class="form-select" v-model="product.published">
                        <option :value="0">Не опубликовано</option>
                        <option :value="1">Опубликовано</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Наличие</label>
                    <select class="form-select" v-model="product.status">
                        <option :value="inStockAvailability">В наличии</option>
                        <option :value="outOfStockAvailability">Нет в наличии</option>
                        <option :value="endsAvailability">Заканчивается</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div v-if="product.preview !== null"
                         class="row justify-content-center text-center"
                    >
                        <label class="form-label">Главное изображение</label>
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
                        <label class="form-label">Главное изображение</label>
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
                        <label class="form-label w-100">Размеры</label>
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
                            >2XL</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xxxl"
                                   v-model="product.xxxl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xxxl"
                            >3XL</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xxxxl"
                                   v-model="product.xxxxl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xxxxl"
                            >4XL</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="xxxxxl"
                                   v-model="product.xxxxxl"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="xxxxxl"
                            >5XL</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Категория товара</label>
                        <multiselect v-model="product.categories"
                                     :options="categories"
                                     :multiple="true"
                                     :close-on-select="false"
                                     :clear-on-select="false"
                                     :preserve-search="true"
                                     placeholder="Поиск..."
                                     label="title"
                                     track-by="id"
                        >
                        </multiselect>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Поставщик</label>
                        <select class="form-select" v-model="product.provider_id">
                            <option :value="null">Не выбрано</option>
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
                    <div v-if="product.colors.length">
                        <label class="form-label w-100">Выбранные цвета</label>
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
                    </div>
                    <label class="form-label w-100">Все цвета</label>
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
                        <label class="form-label">Название товара</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.h1}"
                               type="text"
                               v-model="product.h1"
                               placeholder="Укажите название товара"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Укажите название товара</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="product.title"
                               placeholder="Введите META Title"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="product.description"
                                  placeholder="Введите META Description"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Описание товара</label>
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
                        <label class="form-label">Таблица размеров</label>
                        <editor :api-key="this.$tinyapi" v-model="product.size_table" :init="$tinySettings"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена товара</label>
                    <input class="form-control"
                           :class="{'is-invalid': errors.price}"
                           type="number"
                           v-model="product.price"
                           placeholder="Укажите цену"
                    >
                    <div v-if="errors.price" class="invalid-feedback">Укажите цену товара</div>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена товара со скидкой</label>
                    <input class="form-control"
                           type="number"
                           v-model="product.discount_price"
                           placeholder="Укажите цену со скидкой"
                    >
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена закупки</label>
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
                           placeholder="Укажите артикул"
                    >
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="images"
                           class="form-label"
                    >Выберите файлы для загрузки</label>
                    <input class="form-control"
                           type="file"
                           id="images"
                           multiple
                           @change="uploadImages"
                    >
                </div>
                <loader v-if="isLoadingImages"></loader>
                <div class="row" v-if="product.images.length" v-show="!isLoadingImages">
                    <div class="w-25" v-for="(image,index) in product.images">
                        <img :src="'/storage/products/350/' + image.image" class="card-img-top">
                        <div class="card-body d-flex justify-content-around">
                            <a :href="'/storage/products/' + image.image" class="text-dark" target="_blank">
                                <arrows-angle-expand-icon></arrows-angle-expand-icon>
                            </a>
                            <a href="javascript:" class="text-dark" @click="destroyImage(index)">
                                <backspace-icon></backspace-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                Добавить
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
            isLoadingImages: false,
            product: {
                status: this.inStockAvailability,
                xs: null,
                s: null,
                m: null,
                l: null,
                xl: null,
                xxl: null,
                xxxl: null,
                xxxxl: null,
                xxxxxl: null,
                title: null,
                characteristics: null,
                description: null,
                h1: null,
                content: null,
                published: 0,
                preview: null,
                size_table: null,
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
        destroyImage(index) {
            this.product.images.splice(index, 1)
        },
        uploadImages(event) {
            const self = this;
            Array.from(event.target.files).forEach(function (image) {
                self.isLoadingImages = true;
                const formData = new FormData();
                formData.append('image', image);
                axios.post('/api/products/images/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(({data}) => {
                        self.product.images.push({image: data.url});
                        self.isLoadingImages = false;
                    })
                    .catch((response) => console.log(response));
            });

        },
        deletePreview() {
            this.product.preview = null;
        },
        uploadPreview(event) {
            let formData = new FormData();
            formData.append('image', event.target.files[0]);
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
                        title: 'Товар добавлен!',
                        icon: 'success',
                    });
                    this.isLoading = false;
                    this.errors = [];
                    window.location.href = '/admin/products';
                })
                .catch(({response}) => {
                    this.errors = response.data;
                    console.log(response);
                    this.$swal({
                        title: 'Ошибка',
                        text: 'Проверьте корректность данных или обратитесь к администратору',
                        icon: 'error',
                    });
                    this.isLoading = false;
                })
        }
    }
}
</script>
