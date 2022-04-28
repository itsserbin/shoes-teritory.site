<template>
    <div>
        <loader v-if="isLoading"></loader>
        <div class="row justify-content-center" v-if="categories.length && !isLoading">
            <div class="card__category my-3" v-for="item in categories" :key="item.id">
                <a :href="categoriesRoute + '/' + item.slug" class="text-decoration-none">
                    <div class="card__image">
                        <img :src="item.preview"
                             :alt="lang === 'ru' ? item.title.ru : (lang === 'ua' ? item.title.ua : null)">
                    </div>

                    <div class="card__body">
                        <div class="card__label d-flex align-items-center m-0">
                            {{ lang === 'ru' ? item.title.ru : (lang === 'ua' ? item.title.ua : null) }}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            isLoading: false,
        }
    },
    props: {
        lang: String,
        categoriesRoute: String
    },
    mounted() {
        this.isLoading = true;
        axios.get('/api/v1/category/all-on-prod')
            .then(({data}) => {
                this.categories = data.result;
                this.isLoading = false;
            })
            .catch((response) => {
                this.isLoading = false;
                console.log(response);
            });
    }
}
</script>
