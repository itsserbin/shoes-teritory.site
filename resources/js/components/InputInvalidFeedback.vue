<template>
    <div v-if="errors.length" class="invalid-feedback">
        <span v-for="error in errors">{{ error }}</span>
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
