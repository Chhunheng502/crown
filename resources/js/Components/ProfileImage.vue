<template>
    <img :src="'storage/' + src" class="w-12 h-12 rounded-full object-cover" alt="Profile image">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: ['src'],
})
</script>
