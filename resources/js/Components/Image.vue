<template>
    <img :src="'storage/' + src" :alt="alt">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['src', 'alt'],
})
</script>
