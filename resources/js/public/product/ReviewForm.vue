<template>
    <div>
        <div>
            <div class="button-wrapper">
                <button
                    class="shop__button review-button button button--color_red button--color-text_white"
                    type="button"
                    @click="showReviewModalFunction"
                >
                    <span class="icon-file-text2"></span>
                    <span>{{ textGiveReview }}</span>
                </button>
            </div>


            <div
                :class="{'active-modal' : showReviewModal}"
                class="modal form review-form"
            >
                <loader v-if="isLoading"></loader>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="review-form" class="form review-form" v-if="!isLoading">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ textGiveReview }}</h5>
                                <button type="button"
                                        class="btn-close"
                                        @click="showReviewModal = false"
                                >
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="mb-3">
                                        <div class="input-group mb-1">
                                            <input type="text"
                                                   class="form-control"
                                                   :placeholder="textEnterName"
                                                   v-model="review.name"
                                            >
                                        </div>
                                        <input-invalid-feedback :errors="errors.name"
                                                                v-if="errors.name"
                                        ></input-invalid-feedback>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group mb-1">
                                    <textarea type="text"
                                              class="form-control"
                                              :placeholder="textEnterReview"
                                              v-model="review.comment"
                                              rows="6"
                                    ></textarea>
                                        </div>
                                        <input-invalid-feedback v-if="errors.comment"
                                                                :errors="errors.comment"
                                        ></input-invalid-feedback>

                                    </div>
                                </div>
                                <div class="row justify-content-center mt-2">
                                    <button
                                        class="w-50 review-form__button review-button-modal button button--color_red button--color-text_white"
                                        type="submit"
                                        @click.prevent="sendReview"
                                    >
                                        <span class="icon-arrow-right2"></span>
                                        <span>{{ textGiveReview }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            isLoading: false,
            showReviewModal: false,
            review: {
                product_id: null,
                name: null,
                comment: null,
            }
        }
    },
    props: {
        textGiveReview: String,
        textEnterName: String,
        textEnterReview: String,
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        this.review.product_id = str.substring(n + 1);
    },
    methods: {
        showReviewModalFunction() {
            this.showReviewModal = !this.showReviewModal;
        },
        sendReview() {
            this.isLoading = true;
            axios.post('/send-review', this.review)
                .then(({data}) => this.setSuccessResponse(data))
                .catch(({response}) => this.setErrorResponse(response));
        },
        setSuccessResponse() {
            this.review.name = null;
            this.review.comment = null;
            this.isLoading = false;
            this.errors = [];
            this.showReviewModal = false;
            this.$swal({
                title: 'Отправлено!',
                text: 'Ваш комментарий отправлен на модерацию :)',
                icon: 'success',
            });
        },
        setErrorResponse(response) {
            this.errors = response.data;
            this.isLoading = false;
            console.log(response);
        }
    }
}
</script>
