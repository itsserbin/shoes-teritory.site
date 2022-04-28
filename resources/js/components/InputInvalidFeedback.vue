<template>
    <div class="has-error text-danger">
        <div v-for="error in errors">{{ error }}</div>
    </div>
</template>

<script>
export default {
    name: 'InputInvalidFeedback',
    props: {
        errors: Array
    }
}
</script>
