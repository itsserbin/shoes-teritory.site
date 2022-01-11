<template>
    <div>
        <lingallery
            :iid.sync="currentId"
            :height="600"
            :responsive="true"
            :addons="{ enableLargeView: true }"
            :items="images"
            v-if="images.length"
            class="mb-3"
        />
    </div>
</template>

<script>
import Lingallery from 'lingallery';

export default {
    name: 'ImagesSlider',
    components: {
        Lingallery,
    },
    data() {
        return {
            images: [],
            currentId: null,
        }
    },
    mounted() {
        let str = window.location.pathname;
        let n = str.lastIndexOf('/');
        let id = str.substring(n + 1);

        axios.get('/api/v1/product/get-images/' + id)
            .then(({data}) => {
                this.images.push({
                    'src': '/storage/products/500/' + data.result.preview,
                    'thumbnail': '/storage/products/55/' + data.result.preview,
                    'largeViewSrc': '/storage/products/' + data.result.preview,
                })
                data.result.images.forEach(item => {
                    this.images.push({
                        'src': '/storage/products/500/' + item.image,
                        'thumbnail': '/storage/products/55/' + item.image,
                        'largeViewSrc': '/storage/products/' + item.image,
                    })
                })
            })
            .catch((response) => console.log(response));
    },
    methods: {}
}
</script>

<style>
.lingallery_thumbnails_content {
    text-align: center;
}
</style>
