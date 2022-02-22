<template>
    <div>
        <loader v-if="isLoading"></loader>
        <form v-if="!isLoading" @submit.prevent="updateCostCategory">
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
                Обновить
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
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/bookkeeping/costs/categories/edit/' + id)
            .then(({data}) => {
                this.costCategoryItem = data.result;
                this.isLoading = false;
            })
            .catch(({response}) => {
                console.log(response);
                this.isLoading = false;
            })
    },
    methods: {
        updateCostCategory() {
            this.isLoading = true;
            axios.put('/api/bookkeeping/costs/categories/update/' + this.costCategoryItem.id, this.costCategoryItem)
                .then(() => {
                    this.$swal({
                        icon: 'success',
                        title: 'Обновлено!'
                    });
                    this.isLoading = false;
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
