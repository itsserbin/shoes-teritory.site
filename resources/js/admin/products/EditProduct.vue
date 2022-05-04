<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateProduct">
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
                        <img :src="'/storage/products/350/' + product.preview"
                             :alt="activeLang === 'ru' ? product.title.ru : (activeLang === 'ua' ? product.title.ua : null)"
                             class="w-50"
                        >
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
                    <div class="form-group mb-3" v-if="product.colors.length">
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
                                       :style="'color:' + product_color.hex + ';' "
                                >{{ product_color.name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
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
                                       :style="'color:' + color.hex + ';' "
                                >{{ color.name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs justify-content-center mt-2">
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
            <div class="row my-3">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Название товара</label>
                        <div class="input-group" v-if="activeLang === 'ru'">
                            <input class="form-control"
                                   :class="{'is-invalid': errors.h1}"
                                   type="text"
                                   v-model="product.h1.ru"
                                   placeholder="Введите название товара RU"
                            >
                            <div class="input-group-text">{{ product.h1.ru ? product.h1.ru.length : 0 }}</div>
                        </div>

                        <div class="input-group" v-if="activeLang === 'ua'">
                            <input class="form-control"
                                   :class="{'is-invalid': errors.h1}"
                                   type="text"
                                   v-model="product.h1.ua"
                                   placeholder="Введите название товара UA"
                            >
                            <div class="input-group-text">{{ product.h1.ua ? product.h1.ua.length : 0 }}</div>
                        </div>
                        <div v-if="errors.title" class="invalid-feedback">Введите название товара</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">META Title</label>
                        <div class="input-group" v-if="activeLang === 'ru'">
                            <input class="form-control"
                                   type="text"
                                   v-model="product.title.ru"
                                   placeholder="Введите META Title RU"
                            >
                            <div class="input-group-text">{{ product.title.ru ? product.title.ru.length : 0 }}</div>
                        </div>

                        <div class="input-group" v-if="activeLang === 'ua'">
                            <input class="form-control"
                                   type="text"
                                   v-model="product.title.ua"
                                   placeholder="Введите META Title UA"
                            >
                            <div class="input-group-text">{{ product.title.ua ? product.title.ua.length : 0 }}</div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="form-label">META Description</label>
                        <div class="input-group" v-if="activeLang === 'ua'">
                            <textarea class="form-control"
                                      type="text"
                                      rows="2"
                                      v-model="product.description.ua"
                                      placeholder="Введите META Description UA"
                            ></textarea>
                            <div class="input-group-text">{{ product.description.ua ? product.description.ua.length : 0 }}</div>
                        </div>

                        <div class="input-group" v-if="activeLang === 'ru'">
                           <textarea class="form-control"
                                     type="text"
                                     rows="2"
                                     v-model="product.description.ru"
                                     placeholder="Введите META Description RU"
                                     v-if="activeLang === 'ru'"
                           ></textarea>
                            <div class="input-group-text">{{ product.description.ru ? product.description.ru.length : 0 }}</div>
                        </div>

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
                    <div v-if="errors.price" class="invalid-feedback">Укажите цену</div>
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
                           @change="uploadMultipleImages"
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
                            <a href="javascript:" class="text-dark" @click="destroyImage(image.id,index)">
                                <backspace-icon></backspace-icon>
                            </a>
                        </div>
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
import Editor from '@tinymce/tinymce-vue';

export default {
    components: {
        'editor': Editor,
    },
    data() {
        return {
            activeLang: 'ua',
            isLoading: true,
            isLoadingImages: false,
            product: {
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
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        this.getProduct(id);
        this.getColors();

        axios.get('/api/categories/all')
            .then(({data}) => this.categories = data.result)
            .catch((response) => console.log(response));


        axios.get('/api/providers/list')
            .then(({data}) => this.providers = data.result)
            .catch((response) => console.log(response));
    },
    methods: {
        customCategoriesLabel({title}) {
            return `${title.ru}`
        },
        addCategories(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        },
        destroyImage(id, index) {
            axios.delete('/api/images/destroy/' + id)
                .then(() => this.product.images.splice(index, 1))
                .catch((response) => console.log(response))
        },
        uploadMultipleImages(event) {
            const self = this;
            Array.from(event.target.files).forEach(function (image) {
                self.isLoadingImages = true;
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
                        self.isLoadingImages = false;
                    })
                    .catch((response) => console.log(response));
            });
        },
        getProduct(id) {
            axios.get('/api/products/edit/' + id)
                .then(({data}) => {
                    this.product = data.result;
                    this.isLoading = false;
                })
                .catch((response) => {
                    console.log(response);
                    this.isLoading = false;
                });
        },
        getColors() {
            axios.get('/api/colors/list')
                .then(({data}) => {
                    this.colors = data.result;
                    const self = this;
                    self.product.colors.forEach((product_color_item) => {
                        let color_element = self.colors.find((item) => item.name === product_color_item.name);
                        let color_index = self.colors.indexOf(color_element);
                        self.colors.splice(color_index, 1);
                    })
                })
                .catch((response) => console.log(response));
        },
        getProductColors(id) {
            axios.get('/api/products/colors/get/' + id)
                .then(({data}) => this.product.colors = data.result.colors)
                .catch((response) => console.log(response));
        },
        addColorToProduct(index) {
            axios.post('/api/products/colors/attach/' + this.product.id, {
                'color_id': this.colors[index].id,
                'product_id': this.product.id,
            });
            this.getProductColors(this.product.id);
            this.colors.splice(index, 1);
        },
        destroyColorFromProduct(index) {
            axios.post('/api/products/colors/detach/' + this.product.id, {
                'color_id': this.product.colors[index].id,
                'product_id': this.product.id,
            });
            this.getProductColors(this.product.id);
        },
        deletePreview() {
            this.product.preview = null;
        },
        uploadPreview(event) {
            let formData = new FormData();
            formData.append('image', event.target.files[0]);
            formData.append('type', 'banners');
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
        updateProduct() {
            this.isLoading = true;
            this.errors = [];
            axios.put('/api/products/update/' + this.product.id, this.product)
                .then(() => {
                    this.$swal({
                        title: 'Оновлено!',
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
