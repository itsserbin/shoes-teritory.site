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
                                   id="size_35"
                                   v-model="product.size_35"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_35"
                            >35</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_36"
                                   v-model="product.size_36"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_36"
                            >36</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_37"
                                   v-model="product.size_37"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_37"
                            >37</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_38"
                                   v-model="product.size_38"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_38"
                            >38</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_39"
                                   v-model="product.size_39"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_39"
                            >39</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_40"
                                   v-model="product.size_40"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_40"
                            >40</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_41"
                                   v-model="product.size_41"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_41"
                            >41</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_42"
                                   v-model="product.size_42"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_42"
                            >42</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_43"
                                   v-model="product.size_43"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_43"
                            >43</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_44"
                                   v-model="product.size_44"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_44"
                            >44</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_45"
                                   v-model="product.size_45"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_45"
                            >45</label>

                            <input type="checkbox"
                                   class="btn-check"
                                   id="size_46"
                                   v-model="product.size_46"
                                   autocomplete="off"
                            >
                            <label class="btn btn-outline-primary"
                                   for="size_46"
                            >46</label>
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
                                     :custom-label="customCategoriesLabel"
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
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Название товара</label>
                        <input class="form-control"
                               :class="{'is-invalid': errors.h1}"
                               type="text"
                               v-model="product.h1.ru"
                               placeholder="Введите название товара RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               :class="{'is-invalid': errors.h1}"
                               type="text"
                               v-model="product.h1.ua"
                               placeholder="Введите название товара UA"
                               v-if="activeLang === 'ua'"
                        >
                        <div v-if="errors.title" class="invalid-feedback">Укажите название товара</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <input class="form-control"
                               type="text"
                               v-model="product.title.ru"
                               placeholder="Введите META Title RU"
                               v-if="activeLang === 'ru'"
                        >
                        <input class="form-control"
                               type="text"
                               v-model="product.title.ua"
                               placeholder="Введите META Title UA"
                               v-if="activeLang === 'ua'"
                        >
                    </div>
                    <div class="form-group">
                        <label class="form-label">META Description</label>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="product.description.ua"
                                  placeholder="Введите META Description UA"
                                  v-if="activeLang === 'ua'"
                        ></textarea>
                        <textarea class="form-control"
                                  type="text"
                                  rows="4"
                                  v-model="product.description.ru"
                                  placeholder="Введите META Description RU"
                                  v-if="activeLang === 'ru'"
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Описание товара</label>
                        <editor :api-key="this.$tinyapi"
                                v-model="product.content.ru"
                                :init="this.$tinySettings"
                                v-if="activeLang === 'ru'"
                        />
                        <editor :api-key="this.$tinyapi"
                                v-model="product.content.ua"
                                :init="this.$tinySettings"
                                v-if="activeLang === 'ua'"
                        />
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Характеристики</label>
                        <editor
                            :api-key="this.$tinyapi"
                            v-model="product.characteristics.ua"
                            :init="this.$tinySettings"
                            v-if="activeLang === 'ua'"
                        />
                        <editor
                            :api-key="this.$tinyapi"
                            v-model="product.characteristics.ru"
                            :init="this.$tinySettings"
                            v-if="activeLang === 'ru'"
                        />
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Таблица размеров</label>
                        <editor :api-key="this.$tinyapi" v-model="product.size_table" :init="this.$tinySettings"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена товара</label>
                    <div class="input-group">
                        <input class="form-control text-center"
                               :class="{'is-invalid': errors.price}"
                               type="number"
                               v-model="product.price"
                               placeholder="Укажите цену"
                        >
                        <div class="input-group-text">грн.</div>
                    </div>
                    <div v-if="errors.price" class="invalid-feedback">Укажите цену товара</div>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена товара со скидкой</label>
                    <div class="input-group">
                        <input class="form-control text-center"
                               type="number"
                               v-model="product.discount_price"
                               placeholder="Укажите цену со скидкой"
                        >
                        <div class="input-group-text">грн.</div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label">Цена закупки</label>
                    <div class="input-group">
                        <input class="form-control text-center"
                               type="number"
                               v-model="product.trade_price"
                               placeholder="Укажите цену закупки"
                        >
                        <div class="input-group-text">грн.</div>
                    </div>
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
            activeLang: 'ua',
            isLoading: true,
            isLoadingImages: false,
            product: {
                status: this.inStockAvailability,
                size_35: 0,
                size_36: 0,
                size_37: 0,
                size_38: 0,
                size_39: 0,
                size_40: 0,
                size_41: 0,
                size_42: 0,
                size_43: 0,
                size_44: 0,
                size_45: 0,
                size_46: 0,
                title: {
                    ru: null,
                    ua: null
                },
                characteristics: {
                    ru: null,
                    ua: null,
                },
                description: {
                    ru: null,
                    ua: null
                },
                h1: {
                    ru: null,
                    ua: null
                },
                content: {
                    ru: null,
                    ua: null
                },
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
        customCategoriesLabel({title}) {
            return `${title.ru}`
        },
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
