<template>
    <div class="ms-md-auto">
        <div class="shop__delivery-info m-0 p-2">
            <button
                id="sizes"
                class="shop__sizes-table d-flex"
                type="button"
                @click="showModalSizesFunction"
            >
                <span class="icon-table"></span>
                <span>{{ textSizesTable }}</span>
            </button>
        </div>

        <div id="modal-sizes" class="modal-sizes modal" :class="{'active-modal' : showModalSizes}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title">{{ textSizesTable }}</h5>
                            <button type="button"
                                    class="btn-close"
                                    @click="showModalSizes = false">
                            </button>
                        </div>
                        <div class="modal-body">
                            <table v-if="!this.sizeTable.length" class="table sizes-table">
                                <tr>
                                    <th>Размеры</th>
                                    <th>Чашка</th>
                                    <th>Объем груди</th>
                                    <th>Объем бедер</th>
                                </tr>
                                <tr>
                                    <th>S</th>
                                    <td>A-B</td>
                                    <td>82-85</td>
                                    <td>85-90</td>
                                </tr>
                                <tr>
                                    <th>M</th>
                                    <td>B-C</td>
                                    <td>86-89</td>
                                    <td>91-95</td>
                                </tr>
                                <tr>
                                    <th>L</th>
                                    <td>C-D</td>
                                    <td>90-93</td>
                                    <td>96-100</td>
                                </tr>
                                <tr>
                                    <th>XL</th>
                                    <td>D-E</td>
                                    <td>94-97</td>
                                    <td>101-105</td>
                                </tr>
                            </table>
                            <div v-if="sizeTable.length" class="sizes-table">
                                <div v-html="sizeTable"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showModalSizes: false,
        }
    },
    props: {
        sizeTable: String,
        textSizesTable: String,
    },
    methods: {
        showModalSizesFunction() {
            this.showModalSizes = !this.showModalSizes;
        }

    }
}
</script>
