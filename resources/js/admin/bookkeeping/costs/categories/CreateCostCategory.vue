<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="createCostCategory">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label for="name">Название</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               placeholder="Название траты"
                               v-model="costCategoryItem.title"
                        >
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                        <label for="slug">Slug</label>
                        <input type="text"
                               class="form-control"
                               id="slug"
                               placeholder="Уникальный идентификатор"
                               v-model="costCategoryItem.slug"
                        >
                    </div>
                </div>
            </div>

            <button class="btn btn-danger my-3" type="submit">
                Добавить
            </button>
        </form>
    </div>

</template>

<script>
export default {
    data() {
        return {
            costCategoryItem: {
                title: null,
                slug: null,
            },
            errors: [],
            isLoading: false,
        }
    },
    methods: {
        createCostCategory() {
            this.isLoading = true;
            axios.post('/api/bookkeeping/costs/categories/create', this.costCategoryItem)
                .then(() => {
                    this.$swal({
                        icon: 'success',
                        title: 'Добавлено!'
                    });
                    this.isLoading = false;
                    window.location.href = '/admin/bookkeeping/costs/categories';
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
